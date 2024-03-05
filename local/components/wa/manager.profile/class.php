<?php

use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
use Bitrix\Main\Context,
    Bitrix\Main\Request;

use Bitrix\Main\Diag\Debug;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class ManagerProfile extends CBitrixComponent implements Controllerable
{
    public function configureActions()
    {
        $this->errorCollection = new ErrorCollection();

        return [
            'createUser' => [
                'prefilters' => [],
            ],
            'createOrder' => [
                'prefilters' => [],
            ],
            'addWorkType' => [
                'prefilters' => [],
            ],
            'addUserPost' => [
                'prefilters' => [],
            ],
            'saveOrder' => [
                'prefilters' => [],
            ],
        ];
    }

    public function insertOrderStages($orderID, $postData, $single = false)
    {
        if ($orderID) {
            $arStagesList = [];
            Loader::includeModule("highloadblock");
            $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_STAGES)->fetch();
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();
            if ($single) {
                $data = array(
                    "UF_ORDER_ID" => $orderID,
                    "UF_TYPE_OF_WORK_ID" => $postData['TYPE_OF_WORK_ID'],
                    "UF_START_DATE" => $postData['START_DATE'],
                    "UF_END_DATE" => $postData['END_DATE'],
                    "UF_STATUS" => 10,
                );
                $result = $entity_data_class::add($data);
                if ($result->isSuccess()) {
                    $ID = $result->getId();
                    $arStagesList[] = $ID;
                } else {
                    $errMsg = 'Ошибка: ' . implode(', ', $result->getErrors()) . "";
                    \Bitrix\Main\Diag\Debug::dumpToFile($errMsg, $varName = 'insertOrderStages', $fileName = 'manager_profile_error_log.txt');
                }
            } else {
                $do = true;
                $iter = 1;
                while ($do) {
                    if (isset($postData['STAGE_' . $iter])) {
                        $data = array(
                            "UF_ORDER_ID" => $orderID,
                            "UF_TYPE_OF_WORK_ID" => $postData['STAGE_' . $iter]['TYPE_OF_WORK_ID'],
                            "UF_START_DATE" => $postData['STAGE_' . $iter]['START_DATE'],
                            "UF_END_DATE" => $postData['STAGE_' . $iter]['END_DATE'],
                            "UF_STATUS" => 10,
                        );
                        $result = $entity_data_class::add($data);
                        if ($result->isSuccess()) {
                            $ID = $result->getId();
                            $arStagesList[] = $ID;
                            $iter++;
                        } else {
                            $errMsg = 'Ошибка: ' . implode(', ', $result->getErrors()) . "";
                            \Bitrix\Main\Diag\Debug::dumpToFile($errMsg, $varName = 'insertOrderStages', $fileName = 'manager_profile_error_log.txt');
                        }
                    } else {
                        $do = false;
                    }
                }
            }
            if (!empty($arStagesList)) {
                return $arStagesList;
            } else {
                return false;
            }
        } else {
            $errMsg = 'Ошибка: Отсутствует значение $orderID';
            \Bitrix\Main\Diag\Debug::dumpToFile($errMsg, $varName = 'insertOrderStages', $fileName = 'manager_profile_error_log.txt');
            return false;
        }
    }

    public function createOrderAction(): AjaxJson
    {
        $post = $this->request->getPostList()->toArray();
        if (!empty($post)) {
            $returnValue = null;
            global $USER;
            $rsUser = CUser::GetByID($post['CUSTOMER']);
            $arUser = $rsUser->Fetch();
            $userCompany = $arUser['WORK_COMPANY'];
            $el = new CIBlockElement;
            $PROP = [
                16 => $post['CUSTOMER'],
                18 => $post['EXECUTOR'],
                24 => $post['SERVICE_ID'],
            ];
            Loader::includeModule("iblock");
            $serviceName = null;
            $res = CIBlockElement::GetList([], ["IBLOCK_ID" => SERVICE_IB_ID, "ID" => $post['SERVICE_ID']], false, [], ["NAME"]);
            while ($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();
                if ($arFields) {
                    $serviceName = $arFields["NAME"];
                }
            }
            $arLoadProductArray = array(
                "MODIFIED_BY" => $USER->GetID(),
                "IBLOCK_SECTION_ID" => false,
                "IBLOCK_ID" => ACTIVE_ORDERS_IB_ID,
                "PROPERTY_VALUES" => $PROP,
                "NAME" => $serviceName . ' ' . $userCompany,
                "ACTIVE" => "Y",
            );
            if ($ORDER_ID = $el->Add($arLoadProductArray)) {
                $returnValue = "New ID: " . $ORDER_ID;
                $arStages = $this->insertOrderStages($ORDER_ID, $post);
                $PROPERTY_VALUE[] = [
                    "VALUE" => 3,
                    "DESCRIPTION" => ""
                ];
                CIBlockElement::SetPropertyValuesEx($ORDER_ID, ACTIVE_ORDERS_IB_ID, array('STATUS' => $PROPERTY_VALUE));
                if (isset($post['WAITING_LIST_ELEMENT_ID']) && !empty($post['WAITING_LIST_ELEMENT_ID']) && $post['WAITING_LIST_ELEMENT_ID'] != '') {
                    global $DB;
                    $DB->StartTransaction();
                    if (!CIBlockElement::Delete($post['WAITING_LIST_ELEMENT_ID'])) {
                        $errMsg = 'Ошибка удаления элемента из списка заявок';
                        \Bitrix\Main\Diag\Debug::dumpToFile($errMsg, $varName = 'createOrderAction', $fileName = 'manager_profile_error_log.txt');
                        $DB->Rollback();
                    } else
                        $DB->Commit();
                }
                return AjaxJson::createSuccess($returnValue);
            } else {
                $returnValue = $el->LAST_ERROR;
                return AjaxJson::createError(null, $returnValue);
            }
        } else {
            return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
        }
    }

    public function createUserAction(): AjaxJson
    {
        $post = $this->request->getPostList()->toArray();
        if (!empty($post)) {
            $returnValue = null;
            list($LAST_NAME, $NAME, $SECOND_NAME) = explode(' ', $post['NAME']);
            $PASSWORD = generateRandomString(12);

            //\Bitrix\Main\Diag\Debug::dumpToFile($post, $varName = '$post', $fileName = 'createUserAction_log.txt');
            //\Bitrix\Main\Diag\Debug::dumpToFile($PASSWORD, $varName = '$PASSWORD', $fileName = 'createUserAction_log.txt');

            if (isset($post['WORK_COMPANY'])) {
                $GROUP_ID = [7];
            } else {
                $GROUP_ID = [6];
            }

            $user = new CUser;
            $arFields = array(
                "NAME" => $NAME,
                "LAST_NAME" => $LAST_NAME,
                "SECOND_NAME" => $SECOND_NAME,
                "EMAIL" => $post['EMAIL'],
                "LOGIN" => $post['EMAIL'],
                "PERSONAL_PHONE" => $post['PERSONAL_PHONE'],
                "WORK_COMPANY" => $post['WORK_COMPANY'] ? $post['WORK_COMPANY'] : '',
                "LID" => "ru",
                "ACTIVE" => "Y",
                "GROUP_ID" => $GROUP_ID,
                "UF_USER_POST" => array($post['UF_USER_POST']),
                "PASSWORD" => $PASSWORD,
                "CONFIRM_PASSWORD" => $PASSWORD,
            );
            $ID = $user->Add($arFields);
            if (intval($ID) > 0) {
                $returnValue = "Пользователь успешно добавлен.";

                sendDataToEmail('NEW_USER_REGISTERED', $post['EMAIL'], ['USER_LOGIN' => $post['EMAIL'], 'USER_PASSWD' => $PASSWORD]);

                return AjaxJson::createSuccess($returnValue);
            } else {
                return AjaxJson::createError(null, $user->LAST_ERROR);
            }
        } else {
            return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
        }
    }

    public function addWorkTypeAction(): AjaxJson
    {
        $post = $this->request->getPostList()->toArray();
        if (!empty($post)) {
            $returnValue = null;
            Loader::includeModule("highloadblock");
            $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_TYPES_OF_WORK)->fetch();
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();
            $data = array(
                "UF_NAME" => $post['NAME'],
            );
            $result = $entity_data_class::add($data);
            if ($result->isSuccess()) {
                $returnValue = "Вид работ успешно добавлен.";
                return AjaxJson::createSuccess($returnValue);
            } else {
                $returnValue = 'Ошибка: ' . implode(', ', $result->getErrors()) . "";
                return AjaxJson::createError(null, $returnValue);
            }
        } else {
            return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
        }
    }

    public function addUserPostAction(): AjaxJson
    {
        $post = $this->request->getPostList()->toArray();
        if (!empty($post)) {
            $returnValue = null;
            $arFields = $GLOBALS['USER_FIELD_MANAGER']->GetUserFields("USER");
            if (array_key_exists("UF_USER_POST", $arFields)) {
                if ($post['USER_POST']) {
                    $FIELD_ID = $arFields["UF_USER_POST"]["ID"];
                    $rsType = CUserFieldEnum::GetList(array(), array(
                        'USER_FIELD_NAME' => 'UF_USER_POST',
                    ));
                    $count = count($rsType->arResult);
                    $obEnum = new CUserFieldEnum;
                    $obEnum->SetEnumValues($FIELD_ID, array(
                        "n" . $count => array(
                            "VALUE" => $post['USER_POST'],
                        ),
                    ));
                    $returnValue = "Должность сотрудника успешно добавлена";
                    return AjaxJson::createSuccess($returnValue);
                } else {
                    return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
                }
            } else {
                return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
            }
        } else {
            return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
        }
    }

    public function getWorkTypesList()
    {
        Loader::includeModule("highloadblock");
        $arWorkTypes = [];
        $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_TYPES_OF_WORK)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        $data = $entity_data_class::getList(array(
            "select" => array("*"),
            "order" => array("ID" => "DESC"),
            "filter" => []
        ));
        while ($arData = $data->Fetch()) {
            $arWorkTypes[] = [
                'ID' => $arData['ID'],
                'NAME' => $arData['UF_NAME'],
            ];
        }
        if (!empty($arWorkTypes)) {
            return $arWorkTypes;
        } else {
            return false;
        }
    }

    public function getPartnersList()
    {
        Loader::includeModule("iblock");
        $arUsers = $this->getUserList([7], ['NAME', 'SECOND_NAME', 'LAST_NAME', 'EMAIL', 'PERSONAL_PHONE', 'WORK_COMPANY', 'UF_USER_POST']);
        if (!empty($arUsers)) {
            foreach ($arUsers as &$arUser) {
                $arFilter = array("IBLOCK_ID" => ACTIVE_ORDERS_IB_ID, "PROPERTY_CUSTOMER" => $arUser['ID']);
                $res = CIBlockElement::GetList(["ID" => "DESC"], $arFilter, false, ["nPageSize" => 1], ["ID", "NAME", "PROPERTY_STATUS"]);
                while ($ob = $res->GetNextElement()) {
                    $arFields = $ob->GetFields();
                    $arUser['LAST_ORDER'] = [
                        'ID' => $arFields['ID'],
                        'NAME' => $arFields['NAME'],
                        'STATUS' => $arFields['PROPERTY_STATUS_VALUE'],
                    ];
                }
            }
        }
        if (!empty($arUsers)) {
            return $arUsers;
        } else {
            return false;
        }
    }

    public function getUserList($arUserGroups, $arUserFields)
    {
        $arUsers = [];
        $rsUsers = CUser::GetList(($by = "id"), ($order = "desc"), ["GROUPS_ID" => $arUserGroups]);
        while ($arUser = $rsUsers->Fetch()) {
            if ($arUser) {
                if ($arUserFields) {
                    $arUsers[$arUser['ID']]['ID'] = $arUser['ID'];
                    foreach ($arUserFields as $userField) {
                        $arUsers[$arUser['ID']][$userField] = $arUser[$userField];
                    }
                } else {
                    $arUsers[] = [
                        'ID' => $arUser['ID'],
                    ];
                }
            }
        }
        if (!empty($arUsers)) {
            return $arUsers;
        } else {
            return false;
        }
    }

    public function getUserPostList()
    {
        $obEnum = new \CUserFieldEnum;
        $rsEnum = $obEnum->GetList(array(), array("USER_FIELD_NAME" => 'UF_USER_POST'));
        $enum = array();
        while ($arEnum = $rsEnum->Fetch()) {
            $enum[$arEnum["ID"]]['NAME'] = $arEnum["VALUE"];
        }
        if (!empty($enum)) {
            return $enum;
        } else {
            return false;
        }
    }

    public function getServiceList()
    {
        Loader::includeModule("iblock");
        $arServices = [];
        $arSelect = array("ID", "NAME");
        $arFilter = array("IBLOCK_ID" => SERVICE_IB_ID);
        $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $arServices[$arFields['ID']] = [
                'ID' => $arFields['ID'],
                'NAME' => $arFields['NAME'],
            ];
        }

        if (!empty($arServices)) {
            return $arServices;
        } else {
            return false;
        }
    }

    public function updateOrderStages($orderId, $postData)
    {
        Loader::includeModule("highloadblock");
        $hlOrderStages = [];
        $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_STAGES)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        $data = $entity_data_class::getList(array(
            "select" => array("*"),
            "order" => array("ID" => "ASC"),
            "filter" => array(
                "UF_ORDER_ID" => $orderId,
            )
        ));
        while ($arData = $data->Fetch()) {
            $hlOrderStages[$arData["ID"]] = $arData;
        }
        $do = true;
        $iter = 1;
        $arUpdateRecords = [];
        while ($do) {
            if (isset($postData['STAGE_' . $iter])) {
                if (isset($hlOrderStages[$postData['STAGE_' . $iter]['RECORD_ID']])) {
                    if ($hlOrderStages[$postData['STAGE_' . $iter]['RECORD_ID']]['UF_TYPE_OF_WORK_ID'] != $postData['STAGE_' . $iter]["TYPE_OF_WORK_ID"]) {
                        $arUpdateRecords[$hlOrderStages[$postData['STAGE_' . $iter]['RECORD_ID']]['ID']]['UF_TYPE_OF_WORK_ID'] = $postData['STAGE_' . $iter]["TYPE_OF_WORK_ID"];
                    }
                    if ($hlOrderStages[$postData['STAGE_' . $iter]['RECORD_ID']]['UF_START_DATE']->format('d.m.Y') != $postData['STAGE_' . $iter]["START_DATE"]) {
                        $arUpdateRecords[$hlOrderStages[$postData['STAGE_' . $iter]['RECORD_ID']]['ID']]['UF_START_DATE'] = $postData['STAGE_' . $iter]["START_DATE"];
                    }
                    if ($hlOrderStages[$postData['STAGE_' . $iter]['RECORD_ID']]['UF_END_DATE']->format('d.m.Y') != $postData['STAGE_' . $iter]["END_DATE"]) {
                        $arUpdateRecords[$hlOrderStages[$postData['STAGE_' . $iter]['RECORD_ID']]['ID']]['UF_END_DATE'] = $postData['STAGE_' . $iter]["END_DATE"];
                    }
                    $iter++;
                } else {
                    $this->insertOrderStages($orderId, $postData['STAGE_' . $iter], true);
                    $iter++;
                }
            } else {
                $do = false;
            }
        }
        if (!empty($arUpdateRecords)) {
            $now = new DateTime();
            $is_error = false;
            Loader::includeModule("highloadblock");
            $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_STAGES)->fetch();
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();
            foreach ($arUpdateRecords as $recordId => $recordUpdateValues) {
                $result = $entity_data_class::update($recordId, $recordUpdateValues);
                if (!$result) {
                    $is_error = true;
                    $error = $now->format('d.m.Y H:i:s') . ' Ошибка обновления этапа id= ' . $recordId;
                    \Bitrix\Main\Diag\Debug::dumpToFile($error, $varName = 'updateOrderStages', $fileName = 'manager_profile_error_log.txt');
                }
            }
            if ($is_error) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function saveOrderAction(): AjaxJson
    {
        $post = $this->request->getPostList()->toArray();
        if (!empty($post)) {
            $returnValue = null;
            if (!empty($post["ORDER_ID"])) {
                global $USER;
                CModule::IncludeModule('iblock');
                $el = new CIBlockElement;
                $PROP = [
                    'CUSTOMER' => $post["CUSTOMER"],
                    'EXECUTOR' => $post["EXECUTOR"],
                    'SERVICE_ID' => $post["SERVICE_ID"],
                    'CURRENT_STAGE' => $post["STAGE"],
                    'STATUS' => $post["STATUS"],
                ];
                $arLoadProductArray = array(
                    "MODIFIED_BY" => $USER->GetID(),
                    "PROPERTY_VALUES" => $PROP,
                );
                $res = $el->Update($post["ORDER_ID"], $arLoadProductArray);
                if ($res) {
                    if ($this->updateOrderStages($post["ORDER_ID"], $post)) {
                        $returnValue = 'Изменения сохранены';
                        return AjaxJson::createSuccess($returnValue);
                    } else {
                        return AjaxJson::createError(null, 'Ошибка обновления этапов заказа');
                    }
                } else {
                    return AjaxJson::createError(null, $res->LAST_ERROR);
                }
            } else {
                return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
            }
        } else {
            return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
        }
    }

    public function getOrder($orderId, $arResult)
    {
        $arOrder = [];
        if (isset($orderId) && !empty($orderId)) {
            CModule::IncludeModule('iblock');
            $arSelect = array(
                "ID",
                "NAME",
                "PROPERTY_CUSTOMER",
                "PROPERTY_STATUS",
                "PROPERTY_EXECUTOR",
                "PROPERTY_CURRENT_STAGE",
                "PROPERTY_SERVICE_ID",
            );
            $arFilter = array("IBLOCK_ID" => ACTIVE_ORDERS_IB_ID, 'ID' => $orderId);
            $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
            while ($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();
                $arOrder = [
                    'ID' => $arFields['ID'],
                    'NAME' => $arFields['NAME'],
                    'CUSTOMER' => $arFields['PROPERTY_CUSTOMER_VALUE'],
                    'STATUS' => $arFields['PROPERTY_STATUS_ENUM_ID'],
                    'EXECUTOR' => $arFields['PROPERTY_EXECUTOR_VALUE'],
                    'SERVICE_ID' => $arFields['PROPERTY_SERVICE_ID_VALUE'],
                    'CURRENT_STAGE' => $arFields['PROPERTY_CURRENT_STAGE_VALUE'],
                ];
            }
            if (!empty($arOrder)) {
                if ($arOrder['SERVICE_ID']) {
                    $arOrder['SERVICE_ID'] = $arResult['SERVICE_LIST'][$arOrder['SERVICE_ID']];
                }
                if ($arOrder['CUSTOMER']) {
                    $arOrder['CUSTOMER'] = $arResult['USER_LIST'][$arOrder['CUSTOMER']];
                }
                if ($arOrder['EXECUTOR']) {
                    $arOrder['EXECUTOR'] = $arResult['EXECUTOR_LIST'][$arOrder['EXECUTOR']];
                }

                Loader::includeModule("highloadblock");
                $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_STAGES)->fetch();
                $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                $entity_data_class = $entity->getDataClass();
                $data = $entity_data_class::getList(array(
                    "select" => array("*"),
                    "order" => array("ID" => "ASC"),
                    "filter" => array(
                        "UF_ORDER_ID" => $orderId,
                    )
                ));
                $arStages = [];
                $arStatus = [];
                $rsType = CUserFieldEnum::GetList(array(), array(
                    'USER_FIELD_NAME' => 'UF_STATUS',
                ));
                foreach ($rsType->arResult as $arType) {
                    $arStatus[$arType['ID']] = $arType;
                }
                while ($arData = $data->Fetch()) {
                    $status = null;
                    $arStages[$arData['ID']] = [
                        'TYPE' => $arData['UF_TYPE_OF_WORK_ID'],
                        'TYPE_ID' => $arData['UF_TYPE_OF_WORK_ID'],
                        'PERIOD' => getDayDiff($arData['UF_START_DATE']->format('d.m.Y'), $arData['UF_END_DATE']->format('d.m.Y')),
                        'STATUS' => $arStatus,
                        'SELECTED_STATUS' => $arStatus[$arData['UF_STATUS']],
                        'FROM' => $arData['UF_START_DATE']->format('d.m.Y'),
                        'TO' => $arData['UF_END_DATE']->format('d.m.Y')
                    ];
                }
                $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_TYPES_OF_WORK)->fetch();
                $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                $entity_data_class = $entity->getDataClass();
                foreach ($arStages as &$arStage) {
                    if (isset($arStage['TYPE']) && !empty($arStage['TYPE']) && $arStage['TYPE'] != '') {
                        $data = $entity_data_class::getList(array(
                            "select" => array("*"),
                            "order" => array("ID" => "DESC"),
                            "filter" => array("ID" => $arStage['TYPE'])
                        ));
                        while ($arData = $data->Fetch()) {
                            $arStage['TYPE'] = $arData['UF_NAME'];
                        }
                    }
                }
                $arOrder['STAGES'] = $arStages;
                return $arOrder;
            }
        } else {
            return $arOrder;
        }
    }

    public function init()
    {
        $this->arResult['USER_POST_LIST'] = $this->getUserPostList();
        $this->arResult['USER_LIST'] = $this->getUserList([7], ['WORK_COMPANY']);
        $this->arResult['EXECUTOR_LIST'] = $this->getUserList([6], ['LAST_NAME', 'NAME', 'SECOND_NAME']);
        $this->arResult['WORK_TYPES_LIST'] = $this->getWorkTypesList();
        $this->arResult['PARTNERS_LIST'] = $this->getPartnersList();
        $this->arResult['SERVICE_LIST'] = $this->getServiceList();

        if (isset($this->arParams["ORDER_ID"]) && !empty($this->arParams["ORDER_ID"])) {
            $this->arResult['CURRENT_ORDER'] = $this->getOrder($this->arParams["ORDER_ID"], $this->arResult);
        }

        $request = Context::getCurrent()->getRequest();
        $values = $request->getQueryList();

        if (!empty($values)) {
            if (isset($values["id"]) && !empty($values["id"])) {
                $rsUser = CUser::GetByID($values["id"]);
                $arUser = $rsUser->Fetch();
                $this->arResult['SELECTED_USER'] = [
                    'ID' => $arUser['ID'],
                    'WORK_COMPANY' => $arUser['WORK_COMPANY'],
                ];
            }
            if (isset($values["service"]) && !empty($values["service"])) {
                $res = CIBlockElement::GetList([], ["IBLOCK_ID" => SERVICE_IB_ID, "ID" => $values['service']], false, [], ["ID", "NAME"]);
                while ($ob = $res->GetNextElement()) {
                    $arFields = $ob->GetFields();
                    if ($arFields) {
                        $this->arResult['SELECTED_SERVICE'] = $arFields;
                    }
                }
            }
        }

    }

    public function executeComponent()
    {

        $this->init();

        $this->IncludeComponentTemplate($this->componentPage);

    }
}