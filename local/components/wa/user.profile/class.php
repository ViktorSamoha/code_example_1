<?php

use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

use Bitrix\Main\Diag\Debug;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class UserProfile extends CBitrixComponent implements Controllerable
{
    public function configureActions()
    {
        $this->errorCollection = new ErrorCollection();

        return [
            'deleteUser' => [
                'prefilters' => [],
            ],
            'updateUserData' => [
                'prefilters' => [],
            ],
            'updateUserMailing' => [
                'prefilters' => [],
            ],
            'orderService' => [
                'prefilters' => [],
            ],
            'saveUserProfilePicture' => [
                'prefilters' => [],
            ],
        ];
    }

    public function orderServiceAction(): AjaxJson
    {
        $post = $this->request->getPostList()->toArray();
        if (!empty($post)) {
            if (isset($post['service_id']) && !empty($post['service_id']) && $post['service_id'] != '' && $post['service_id'] != 'undefined') {
                Loader::includeModule("iblock");
                $serviceName = null;
                $res = CIBlockElement::GetList([], ["IBLOCK_ID" => SERVICE_IB_ID, "ID" => $post['service_id']], false, [], ["NAME"]);
                while ($ob = $res->GetNextElement()) {
                    $arFields = $ob->GetFields();
                    if ($arFields) {
                        $serviceName = $arFields["NAME"];
                    }
                }
                $elementName = 'Заявка на ' . $serviceName . ' от ' . $post['user_company_name'];
                global $USER;
                $el = new CIBlockElement;
                $PROP = array();
                $PROP[21] = $post['service_id'];
                $PROP[22] = $post['user_company_name'];
                $PROP[23] = $post['user_id'];
                $arLoadProductArray = array(
                    "MODIFIED_BY" => $USER->GetID(),
                    "IBLOCK_SECTION_ID" => false,
                    "IBLOCK_ID" => WAITING_LIST_IB_ID,
                    "PROPERTY_VALUES" => $PROP,
                    "NAME" => $elementName,
                );
                if ($el->Add($arLoadProductArray)) {
                    //формируем перечень менеджеров
                    $arManagers = [];
                    $rsUsers = CUser::GetList(($by = "id"), ($order = "desc"), ["GROUPS_ID" => [6]]);
                    while ($arUser = $rsUsers->Fetch()) {
                        $arManagers[] = $arUser['EMAIL'];
                    }
                    //получаем данные пользователя
                    $rUser = CUser::GetByID($post['user_id']);
                    $_arUser = $rUser->Fetch();
                    $userFio = $_arUser['LAST_NAME'] . ' ' . $_arUser['LAST_NAME'] . ' ' . $_arUser['SECOND_NAME'];
                    $userEmail = $_arUser['EMAIL'];
                    $userPhone = $_arUser['PERSONAL_PHONE'];

                    if (!empty($arManagers)) {
                        foreach ($arManagers as $managerEmail) {
                            sendDataToEmail(
                                'NEW_SERVICE_REQUEST',
                                $managerEmail,
                                [
                                    'USER_FIO' => $userFio,
                                    'USER_EMAIL' => $userEmail,
                                    'USER_PHONE' => $userPhone,
                                    'SERVICE_NAME' => $serviceName,
                                ]);
                        }
                    }
                    return AjaxJson::createSuccess('Заявка на услугу успешно добавлена');
                } else {
                    return AjaxJson::createError(null, $el->LAST_ERROR);
                }
            } else {
                return AjaxJson::createError(null, 'Ошибка - Выберите услугу');
            }
        } else {
            return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
        }
    }

    public function saveUserProfilePictureAction(): AjaxJson
    {
        if (!empty($_FILES["PERSONAL_PHOTO"])) {

            $fileId = CFile::SaveFile($_FILES["PERSONAL_PHOTO"], 'user_photo');
            $arFile = CFile::MakeFileArray($fileId);
            global $USER;
            $user = new CUser;
            if ($user->Update($USER->GetID(), ['PERSONAL_PHOTO' => $arFile])) {
                return AjaxJson::createSuccess('Фотография успешно добавлена');
            } else {
                return AjaxJson::createError(null, $user->LAST_ERROR);
            }
        } else {
            return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
        }
    }

    public function deleteUserAction(): AjaxJson
    {
        $post = $this->request->getPostList()->toArray();
        if (!empty($post)) {
            if ($post['id']) {
                $returnValue = null;
                if (CUser::Delete($post['id'])) {
                    $returnValue = true;
                }
                return AjaxJson::createSuccess($returnValue);
            } else {
                return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
            }
        } else {
            return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
        }
    }

    public function updateUserMailingAction(): AjaxJson
    {
        $post = $this->request->getPostList()->toArray();
        if (!empty($post)) {
            $returnValue = null;
            global $USER;
            $userId = $USER->GetID();
            $user = new CUser;
            $arValues = [];
            foreach ($post as $propId => $propValue) {
                if ($propValue == 'true') {
                    $arValues[] = $propId;
                }
            }
            $fields = array(
                "UF_USER_MAILING" => $arValues,
            );
            $user->Update($userId, $fields);
            if ($user) {
                $returnValue = ['msg' => 'Данные успешно сохранены!'];
            } else {
                $strError = $user->LAST_ERROR;
                return AjaxJson::createError(null, $strError);
            }
            return AjaxJson::createSuccess($returnValue);
        } else {
            return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
        }
    }

    public function updateUserDataAction(): AjaxJson
    {
        $post = $this->request->getPostList()->toArray();
        if (!empty($post)) {
            global $USER;
            $userId = $USER->GetID();
            $user = new CUser;
            $returnValue = null;
            switch ($post["name"]) {
                case 'user-name':
                    $user->Update($userId, ['NAME' => $post["value"]]);
                    if ($user) {
                        $returnValue = ['msg' => 'Данные успешно сохранены!'];
                    } else {
                        $strError = $user->LAST_ERROR;
                        return AjaxJson::createError(null, $strError);
                    }
                    break;
                case 'user-work-company':
                    $user->Update($userId, ['WORK_COMPANY' => $post["value"]]);
                    if ($user) {
                        $returnValue = ['msg' => 'Данные успешно сохранены!'];
                    } else {
                        $strError = $user->LAST_ERROR;
                        return AjaxJson::createError(null, $strError);
                    }
                    break;
                case 'user-personal-phone':
                    $user->Update($userId, ['PERSONAL_PHONE' => $post["value"]]);
                    if ($user) {
                        $returnValue = ['msg' => 'Данные успешно сохранены!'];
                    } else {
                        $strError = $user->LAST_ERROR;
                        return AjaxJson::createError(null, $strError);
                    }
                    break;
                case 'user-email':
                    $user->Update($userId, ['EMAIL' => $post["value"]]);
                    if ($user) {
                        $returnValue = ['msg' => 'Данные успешно сохранены!'];
                    } else {
                        $strError = $user->LAST_ERROR;
                        return AjaxJson::createError(null, $strError);
                    }
                    break;
                case 'user-new-pass':
                    if ($post["value"] && $post["value"] != '' && !empty($post["value"])) {
                        $curUser = CUser::GetByID($userId)->Fetch();
                        $arResult = $user->ChangePassword($curUser['LOGIN'], $curUser['CHECKWORD'], $post["value"], $post["value"]);
                        if ($arResult["TYPE"] == "OK") {
                            $returnValue = ['msg' => 'Пароль успешно сменен!'];
                        } else {
                            return AjaxJson::createError(null, $arResult);
                        }
                    } else {
                        return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
                    }
                    break;
                case 'user-telegram':
                    $user->Update($userId, ['UF_TELEGRAM_LINK' => $post["value"]]);
                    if ($user) {
                        $returnValue = ['msg' => 'Данные успешно сохранены!'];
                    } else {
                        $strError = $user->LAST_ERROR;
                        return AjaxJson::createError(null, $strError);
                    }
                    break;
                case 'user-whatsapp':
                    $user->Update($userId, ['UF_WHATSAPP_LINK' => $post["value"]]);
                    if ($user) {
                        $returnValue = ['msg' => 'Данные успешно сохранены!'];
                    } else {
                        $strError = $user->LAST_ERROR;
                        return AjaxJson::createError(null, $strError);
                    }
                    break;
            }
            return AjaxJson::createSuccess($returnValue);
        } else {
            return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
        }
    }

    public function getStepStatus($orderId, $stepId)
    {
        Loader::includeModule("highloadblock");
        $status = 'В ожидании';
        $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_STAGES)->fetch();
        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        $data = $entity_data_class::getList(array(
            "select" => array("UF_STATUS"),
            "order" => array(),
            "filter" => array(
                "UF_ORDER_ID" => $orderId,
                "ID" => $stepId
            )
        ));
        while ($arData = $data->Fetch()) {
            $rsType = CUserFieldEnum::GetList(array(), array(
                'USER_FIELD_NAME' => 'UF_STATUS',
            ));
            foreach ($rsType->arResult as $arType) {
                if ($arType['ID'] == $arData['UF_STATUS']) {
                    $status = $arType['VALUE'];
                }
            }
        }
        return $status;
    }

    public function getOrderServiceType($serviceId)
    {
        $serviceName = null;
        $res = CIBlockElement::GetList([], ["IBLOCK_ID" => SERVICE_IB_ID, 'ID' => $serviceId], false, [], ["NAME"]);
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            if ($arFields) {
                $serviceName = $arFields["NAME"];
            }
        }
        if ($serviceName) {
            return $serviceName;
        } else {
            return false;
        }
    }

    public function getOrders($arFilter, $arSelect)
    {
        $user = getUserData();
        $arResult = [];
        global $USER;
        $userId = $USER->GetID();

        Loader::includeModule("iblock");

        $res = CIBlockElement::GetList(array(), $arFilter, false, [], $arSelect);
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            if ($user['IS_ADMIN'] || $user['IS_MANAGER']) {
                $arResult[$arFields["ID"]] = [
                    'ID' => $arFields["ID"],
                    'NAME' => $arFields["NAME"],
                    'CUSTOMER' => $this->getUserData($arFields["PROPERTY_CUSTOMER_VALUE"], ['WORK_COMPANY']),
                    'STEP' => $arFields["PROPERTY_CURRENT_STAGE_VALUE"],
                    'STATUS' => $this->getStepStatus($arFields["ID"], $arFields["PROPERTY_CURRENT_STAGE_VALUE"]),
                    'EXECUTOR' => $this->getUserData($userId, ['LAST_NAME', 'NAME', 'SECOND_NAME']),
                    'TYPE' => 'order'
                ];
            } elseif ($user['IS_SIMPLE_USER']) {
                $arResult[$arFields["ID"]] = [
                    'ID' => $arFields["ID"],
                    'SERVICE_TYPE' => $this->getOrderServiceType($arFields["PROPERTY_SERVICE_ID_VALUE"]),
                    'STATUS' => 'Ожидает обработки',
                    'TYPE' => 'request'
                ];
                if ($arFields["PROPERTY_STATUS_VALUE"]) {
                    $arResult[$arFields["ID"]]['STATUS'] = $this->getStepStatus($arFields["ID"], $arFields["PROPERTY_CURRENT_STAGE_VALUE"]);
                    $arResult[$arFields["ID"]]['TYPE'] = 'order';
                }
            }
        }

        if (!empty($arResult)) {
            foreach ($arResult as &$arOrder) {
                if ($arOrder['STEP']) {
                    Loader::includeModule("highloadblock");
                    $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_STAGES)->fetch();
                    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                    $entity_data_class = $entity->getDataClass();
                    $data = $entity_data_class::getList(array(
                        "select" => array("UF_TYPE_OF_WORK_ID"),
                        "order" => array(),
                        "filter" => array(
                            "UF_ORDER_ID" => $arOrder['ID'],
                            "ID" => $arOrder['STEP']
                        )
                    ));
                    $type_id = null;
                    while ($arData = $data->Fetch()) {
                        if ($arData['UF_TYPE_OF_WORK_ID']) {
                            $type_id = $arData['UF_TYPE_OF_WORK_ID'];
                        }
                    }
                    if ($type_id) {
                        unset($hlblock, $entity, $entity_data_class, $data, $arData);
                        $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_TYPES_OF_WORK)->fetch();
                        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                        $entity_data_class = $entity->getDataClass();
                        $data = $entity_data_class::getList(array(
                            "select" => array("UF_NAME"),
                            "order" => array(),
                            "filter" => array(
                                "ID" => $type_id
                            )
                        ));
                        while ($arData = $data->Fetch()) {
                            $arOrder['STEP'] = $arData['UF_NAME'];
                        }
                    }
                }
                if ($arOrder['SERVICE_TYPE']) {
                    $res = CIBlockElement::GetList([], ["IBLOCK_ID" => SERVICE_IB_ID, "ID" => $arOrder['SERVICE_TYPE']], false, [], ["NAME"]);
                    while ($ob = $res->GetNextElement()) {
                        $arFields = $ob->GetFields();
                        if ($arFields) {
                            $arOrder['SERVICE_TYPE'] = $arFields["NAME"];
                        }
                    }
                }
            }
        }

        if (!empty($arResult)) {
            return $arResult;
        } else {
            return [];
        }
    }

    public function getUserOrderList()
    {
        $user = getUserData();
        Loader::includeModule("iblock");
        $arUserOrders = [];
        global $USER;
        $userId = $USER->GetID();

        if ($user['IS_SIMPLE_USER']) {
            //активные заказы
            $arActiveOrders = $this->getOrders(["IBLOCK_ID" => ACTIVE_ORDERS_IB_ID, "PROPERTY_CUSTOMER" => $userId], ["ID", "NAME", "PROPERTY_STATUS", "PROPERTY_CUSTOMER", "PROPERTY_CURRENT_STAGE", "PROPERTY_SERVICE_ID"]);
            //архивные заказы
            $arArchiveOrders = $this->getOrders(["IBLOCK_ID" => ARCHIVE_ORDERS_IB_ID, "PROPERTY_CUSTOMER" => $userId], ["ID", "NAME", "PROPERTY_STATUS", "PROPERTY_CUSTOMER"]);

        } else {
            //активные заказы
            $arActiveOrders = $this->getOrders(["IBLOCK_ID" => ACTIVE_ORDERS_IB_ID, "PROPERTY_EXECUTOR" => $userId], ["ID", "NAME", "PROPERTY_STATUS", "PROPERTY_CUSTOMER", "PROPERTY_CURRENT_STAGE", "PROPERTY_SERVICE_ID"]);
            //архивные заказы
            $arArchiveOrders = $this->getOrders(["IBLOCK_ID" => ARCHIVE_ORDERS_IB_ID, "PROPERTY_EXECUTOR" => $userId], ["ID", "NAME", "PROPERTY_STATUS", "PROPERTY_CUSTOMER", "PROPERTY_CURRENT_STAGE"]);
        }
        //заявки
        $arWaitingOrders = $this->getOrders(["IBLOCK_ID" => WAITING_LIST_IB_ID, "PROPERTY_CONTACT_PERSON_ID" => $userId], ["ID", "NAME", "PROPERTY_SERVICE_TYPE", "PROPERTY_CUSTOMER", "PROPERTY_CONTACT_PERSON_ID"]);

        if (isset($this->arParams['FILTER']) && $this->arParams['FILTER'] != '') {
            switch ($this->arParams['FILTER']['ORDER_TYPE']) {
                case 'active':
                    $arUserOrders = $arActiveOrders;
                    break;
                case 'arch':
                    $arUserOrders = $arArchiveOrders;
                    break;
                case 'wait':
                    $arUserOrders = $arWaitingOrders;
                    break;
            }
        } else {
            if ($user['IS_SIMPLE_USER']) {
                $arUserOrders = array_merge($arActiveOrders, $arArchiveOrders, $arWaitingOrders);
            } else {
                $arUserOrders = array_merge($arActiveOrders, $arArchiveOrders);
            }
        }

        if (!empty($arUserOrders)) {
            return $arUserOrders;
        } else {
            return false;
        }
    }

    public function getUserMailingList()
    {
        $obEnum = new \CUserFieldEnum;
        $rsEnum = $obEnum->GetList(array(), array("USER_FIELD_NAME" => 'UF_USER_MAILING'));
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

    public function getUserData($id = null, $arUserFields = null)
    {
        if (isset($id) && $id != null) {
            $userId = $id;
        } else {
            global $USER;
            $userId = $USER->GetID();
        }
        $rsUser = CUser::GetByID($userId);
        if (is_array($arUserFields)) {
            $returnFields = [];
            $userFields = $rsUser->Fetch();
            foreach ($userFields as $userFieldName => $userField) {
                foreach ($arUserFields as $fieldName) {
                    if ($fieldName == $userFieldName) {
                        $returnFields[$userFieldName] = $userField;
                    }
                }
            }
            if (!empty($returnFields)) {
                return $returnFields;
            } else {
                return false;
            }
        } else {
            return $rsUser->Fetch();
        }
    }

    public function init()
    {
        $this->arResult['USER'] = $this->getUserData();
        $this->arResult['USER_MAILING_LIST'] = $this->getUserMailingList();
        $this->arResult['USER_ORDERS_LIST'] = $this->getUserOrderList();
    }

    public function executeComponent()
    {

        $this->init();

        $this->IncludeComponentTemplate($this->componentPage);

    }
}