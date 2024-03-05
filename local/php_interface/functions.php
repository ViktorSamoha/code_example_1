<?php

use Bitrix\Main\Mail\Event,
    Bitrix\Main\Loader,
    Bitrix\Highloadblock as HL,
    Bitrix\Main\Entity;

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getUserData()
{
    global $USER;
    CModule::IncludeModule("iblock");
    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();
    $arGroups = $USER->GetUserGroupArray();

    $isAdmin = false;
    $isManager = false;
    $isSimpleUser = false;

    foreach ($arGroups as $group_id) {
        if ($group_id == SITE_ADMIN_GROUP_ID) {
            $isAdmin = true;
        }
        if ($group_id == SITE_MANAGER_GROUP_ID) {
            $isManager = true;
        }
        if ($group_id == SITE_SIMPLE_USER_GROUP_ID) {
            $isSimpleUser = true;
        }
    }

    $userData = [
        "ID" => $arUser["ID"],
        "EMAIL" => $arUser["EMAIL"],
        "LOGIN" => $arUser["LOGIN"],
        "NAME" => $arUser["NAME"],
        "IS_ADMIN" => $isAdmin,
        "IS_MANAGER" => $isManager,
        "IS_SIMPLE_USER" => $isSimpleUser,
        "GROUPS" => $arGroups,
        "PERSONAL_PHOTO" => CFile::GetPath($arUser["PERSONAL_PHOTO"]),
    ];

    return $userData;
}

function getDayDiff($from, $to = false)
{
    $from = new DateTime($from);
    if ($to)
        $to = new DateTime($to);
    else
        $to = new DateTime();
    $interval = $from->diff($to);
    $diff = intval($interval->format('%d'));
    return $diff;
}

function sendDataToEmail($event, $email, $arData)
{
    if ($event && $email && $arData) {

        $arSend = [
            "EVENT_NAME" => $event,
            "LID" => "s1",
            "C_FIELDS" => array(
                "EMAIL" => $email,
            ),
        ];

        if (is_array($arData)) {
            foreach ($arData as $field => $value) {
                $arSend["C_FIELDS"][$field] = $value;
            }
        }

        Event::send($arSend);
    }
}

//функция отправляет заказ в архив
function archiveOrder($orderId)
{
    $curTime = new DateTime();
    if ($orderId) {
        $archiveOrderProps = [];
        global $USER;
        global $DB;
        //достаем поля заказа
        $arSelect = array("ID", "NAME", "PROPERTY_CUSTOMER", "PROPERTY_EXECUTOR", "PROPERTY_SERVICE_ID",);
        $arFilter = array("IBLOCK_ID" => ACTIVE_ORDERS_IB_ID, 'ID' => $orderId);
        $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            if ($arFields) {
                $orderName = $arFields["NAME"];
                $archiveOrderProps = [
                    'ORDER_ID' => $arFields["ID"],
                    'CUSTOMER' => $arFields["PROPERTY_CUSTOMER_VALUE"],
                    'EXECUTOR' => $arFields["PROPERTY_EXECUTOR_VALUE"],
                    'SERVICE_ID' => $arFields["PROPERTY_SERVICE_ID_VALUE"],
                ];
            }
        }
        //достаем привязанные документы к заказу
        $orderDocs = array();
        $res = CIBlockElement::GetProperty(ACTIVE_ORDERS_IB_ID, $orderId, "sort", "asc", array("CODE" => "DOCS"));
        while ($ob = $res->GetNext()) {
            $orderDocs[] = $ob['VALUE'];
        }
        if (!empty($orderDocs)) {
            $archiveOrderProps['DOCS'] = $orderDocs;
        }
        if ($orderName && !empty($archiveOrderProps)) {
            //формируем новый элемент
            $el = new CIBlockElement;
            $arLoadProductArray = array(
                "MODIFIED_BY" => $USER->GetID(),
                "IBLOCK_SECTION_ID" => false,
                "IBLOCK_ID" => ARCHIVE_ORDERS_IB_ID,
                "PROPERTY_VALUES" => $archiveOrderProps,
                "NAME" => $orderName . ' №' . $orderId,
                "ACTIVE" => "Y",
            );
            //сохраняем новый элемент
            if (!$el->Add($arLoadProductArray)) {
                $error = $el->LAST_ERROR;
                $error_msg = $curTime->format('d.m.Y H:i:s') . ' Ошибка переноса заказа (' . $orderId . ') в архив - ' . $error;
                \Bitrix\Main\Diag\Debug::dumpToFile($error_msg, $varName = 'archiveOrder', $fileName = 'functions_error_log.txt');
            } else {
                //удаляем заказ
                $DB->StartTransaction();
                if (!CIBlockElement::Delete($orderId)) {
                    $DB->Rollback();
                } else {
                    $DB->Commit();
                }
            }
        }
    } else {
        $error = 'Отсутствует значение $orderId';
        $error_msg = $curTime->format('d.m.Y H:i:s') . ' Ошибка переноса заказа (' . $orderId . ') в архив - ' . $error;
        \Bitrix\Main\Diag\Debug::dumpToFile($error_msg, $varName = 'archiveOrder', $fileName = 'functions_error_log.txt');
    }
}

//функция проверяет завершенность всех этапов заказа
function checkOrderProgress($orderId)
{
    Loader::includeModule("highloadblock");

    $arStatuses = [];
    $arOrderStatuses = [];
    $rsType = CUserFieldEnum::GetList(array(), array(
        'USER_FIELD_NAME' => 'UF_STATUS',
    ));
    foreach ($rsType->arResult as $arType) {
        $arStatuses[$arType['ID']] = $arType;
    }

    $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_STAGES)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    $data = $entity_data_class::getList(array(
        "select" => array("UF_STATUS"),
        "order" => array("ID" => "DESC"),
        "filter" => array("UF_ORDER_ID" => $orderId)
    ));

    while ($arData = $data->Fetch()) {
        $arOrderStatuses[] = $arData['UF_STATUS'];
    }

    if (!empty($arStatuses) && !empty($arOrderStatuses)) {
        $arReady = [];
        foreach ($arOrderStatuses as $orderStatusId) {
            if ($arStatuses[$orderStatusId]['VALUE'] == 'Завершен') {
                $arReady[] = true;
            }
        }
        if (!empty($arReady)) {
            if (count($arReady) == count($arOrderStatuses)) {
                archiveOrder($orderId);
            }
        }
    }
}

function modifierDetailText($arResult, $field)
{

    /*документы*/
    $arr_str = preg_match_all("#{short_doc:(.*?)}#", $arResult[$field], $arr);
    foreach ($arr[0] as $key => $strDoc) {
        $docString = '';
        ob_start();
        $docSectionName = explode("|", $arr[1][$key]);

        ?>
        <div class="documents">
            <?
            if (!empty($docSectionName[1]))
                $arr[1][$key] = $docSectionName[1];

            if ($arr[1][$key] == 'all') {
                if (is_array($arResult['DISPLAY_PROPERTIES']['DOCS']['FILE_VALUE'][0])) {
                    foreach ($arResult['DISPLAY_PROPERTIES']['DOCS']['FILE_VALUE'] as $doc) {
                        $atrItem = '';
                        $pos = strpos($doc['DESCRIPTION'], '|');
                        if ($pos !== false) {
                            $atrItem = substr($doc['DESCRIPTION'], 0, $pos);
                            $fileName = substr($doc['DESCRIPTION'], $pos + 1);
                        } else {
                            //$fileName = $doc['DESCRIPTION'];
                            $fileName = $doc['DESCRIPTION'] ? $doc['DESCRIPTION'] : $doc['ORIGINAL_NAME'];
                        }
                        ?>
                        <a href="<?= $doc['SRC'] ?>" class="document" target="_blank">
                            <div class="document_icon">
                                <svg width="35" height="38" viewBox="0 0 35 38" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                            d="M0 36V0H19L28 9V23.6923H26.4616V10H18V1.53845H1.53845V34.4616H21.6923V36H0ZM33.9 37.0115L26.7693 29.8809V36.6309H25.2307V27.2308H34.6308V28.7693H27.8308L34.9616 35.9L33.9 37.0115Z"
                                            fill="#DE6396"/>
                                </svg>
                            </div>
                            <span class="document_title"><?= $fileName ?></span>
                        </a>
                        <?
                    }
                } else {
                    $doc = $arResult['DISPLAY_PROPERTIES']['DOCS']['FILE_VALUE'];
                    $pos = strpos($doc['DESCRIPTION'], '|');
                    if ($pos !== false) {
                        $atrItem = substr($doc['DESCRIPTION'], 0, $pos);
                        $fileName = substr($doc['DESCRIPTION'], $pos + 1);
                    } else {
                        //$fileName = $doc['DESCRIPTION'];
                        $fileName = $doc['DESCRIPTION'] ? $doc['DESCRIPTION'] : $doc['ORIGINAL_NAME'];
                    }
                    ?>
                    <a href="<?= $doc['SRC'] ?>" class="document" target="_blank">
                        <div class="document_icon">
                            <svg width="35" height="38" viewBox="0 0 35 38" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M0 36V0H19L28 9V23.6923H26.4616V10H18V1.53845H1.53845V34.4616H21.6923V36H0ZM33.9 37.0115L26.7693 29.8809V36.6309H25.2307V27.2308H34.6308V28.7693H27.8308L34.9616 35.9L33.9 37.0115Z"
                                        fill="#DE6396"/>
                            </svg>
                        </div>
                        <span class="document_title"><?= $fileName ?></span>
                    </a>
                    <?
                }
            } else {
                $docNum = explode(",", $arr[1][$key]);
                foreach ($docNum as $number) {
                    $atrItem = '';
                    if (is_array($arResult['DISPLAY_PROPERTIES']['DOCS']['FILE_VALUE'][0])) {
                        $doc = $arResult['DISPLAY_PROPERTIES']['DOCS']['FILE_VALUE'][$number];
                        $pos = strpos($doc['DESCRIPTION'], '|');
                        if ($pos !== false) {
                            $atrItem = substr($doc['DESCRIPTION'], 0, $pos);
                            $fileName = substr($doc['DESCRIPTION'], $pos + 1);
                        } else {
                            $fileName = $doc['DESCRIPTION'];
                        }
                    } elseif ($number == 0) {
                        $doc = $arResult['DISPLAY_PROPERTIES']['DOCS']['FILE_VALUE'];
                        $pos = strpos($doc['DESCRIPTION'], '|');
                        if ($pos !== false) {
                            $atrItem = substr($doc['DESCRIPTION'], 0, $pos);
                            $fileName = substr($doc['DESCRIPTION'], $pos + 1);
                        } else {
                            $fileName = $doc['DESCRIPTION'];
                        }
                    }
                    ?>
                    <a href="<?= $doc['SRC'] ?>" class="document" target="_blank">
                        <div class="document_icon">
                            <svg width="35" height="38" viewBox="0 0 35 38" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M0 36V0H19L28 9V23.6923H26.4616V10H18V1.53845H1.53845V34.4616H21.6923V36H0ZM33.9 37.0115L26.7693 29.8809V36.6309H25.2307V27.2308H34.6308V28.7693H27.8308L34.9616 35.9L33.9 37.0115Z"
                                        fill="#DE6396"/>
                            </svg>
                        </div>
                        <span class="document_title"><?= $fileName ?></span>
                    </a>
                    <?
                }
            }
            ?>
        </div>
        <?
        $docString = ob_get_contents();
        ob_end_clean();
        $strDoc = substr_replace($strDoc, '\\', strpos($strDoc, '|'), 0);
        $arResult[$field] = preg_replace('/' . $strDoc . '/', $docString, $arResult[$field]);
    }

    /*Ссылки*/
    $arr_str = preg_match_all("#{short_link:(.*?)}#", $arResult[$field], $arr);
    $arLinks = [];
    foreach ($arResult['DISPLAY_PROPERTIES']['LINK_LIST']['VALUE'] as $position => $linkValue) {
        $arLinks[$position]['VALUE'] = $linkValue;
        $arLinks[$position]['DESCRIPTION'] = $arResult['DISPLAY_PROPERTIES']['LINK_LIST']['DESCRIPTION'][$position];
    }

    foreach ($arr[0] as $key => $strDoc) {
        $linkString = '';
        ob_start();
        $docSectionName = explode("|", $arr[1][$key]);

        ?>
        <div class="documents">
            <?
            if (!empty($docSectionName[1]))
                $arr[1][$key] = $docSectionName[1];

            if ($arr[1][$key] == 'all') {
                foreach ($arLinks as $link) {
                    $atrItem = '';
                    $pos = strpos($link['DESCRIPTION'], '|');
                    if ($pos !== false) {
                        $atrItem = substr($link['DESCRIPTION'], 0, $pos);
                        $fileName = substr($link['DESCRIPTION'], $pos + 1);
                    } else {
                        $fileName = $link['DESCRIPTION'];
                    }
                    ?>
                    <a href="<?= $link['VALUE'] ?>" class="document" target="_blank">
                        <div class="document_icon">
                            <svg width="35" height="38" viewBox="0 0 35 38" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M0 36V0H19L28 9V23.6923H26.4616V10H18V1.53845H1.53845V34.4616H21.6923V36H0ZM33.9 37.0115L26.7693 29.8809V36.6309H25.2307V27.2308H34.6308V28.7693H27.8308L34.9616 35.9L33.9 37.0115Z"
                                        fill="#DE6396"/>
                            </svg>
                        </div>
                        <span class="document_title"><?= $fileName ?></span>
                    </a>
                    <?

                }
            } else {
                $docNum = explode(",", $arr[1][$key]);
                foreach ($docNum as $number) {
                    $atrItem = '';
                    if (is_array($arLinks)) {
                        $link = $arLinks[$number];
                        $pos = strpos($link['DESCRIPTION'], '|');
                        if ($pos !== false) {
                            $atrItem = substr($link['DESCRIPTION'], 0, $pos);
                            $fileName = substr($link['DESCRIPTION'], $pos + 1);
                        } else {
                            $fileName = $link['DESCRIPTION'];
                        }
                    } elseif ($number == 0) {
                        $link = $arLinks[0];
                        $pos = strpos($link['DESCRIPTION'], '|');
                        if ($pos !== false) {
                            $atrItem = substr($link['DESCRIPTION'], 0, $pos);
                            $fileName = substr($link['DESCRIPTION'], $pos + 1);
                        } else {
                            $fileName = $link['DESCRIPTION'];
                        }
                    }
                    ?>
                    <a href="<?= $link['VALUE'] ?>" class="document" target="_blank">
                        <div class="document_icon">
                            <svg width="35" height="38" viewBox="0 0 35 38" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                        d="M0 36V0H19L28 9V23.6923H26.4616V10H18V1.53845H1.53845V34.4616H21.6923V36H0ZM33.9 37.0115L26.7693 29.8809V36.6309H25.2307V27.2308H34.6308V28.7693H27.8308L34.9616 35.9L33.9 37.0115Z"
                                        fill="#DE6396"/>
                            </svg>
                        </div>
                        <span class="document_title"><?= $fileName ?></span>
                    </a>
                    <?
                }
            }
            ?>
        </div>
        <?
        $linkString = ob_get_contents();
        ob_end_clean();
        $strDoc = substr_replace($strDoc, '\\', strpos($strDoc, '|'), 0);
        $arResult[$field] = preg_replace('/' . $strDoc . '/', $linkString, $arResult[$field]);
    }

    return $arResult[$field];
}