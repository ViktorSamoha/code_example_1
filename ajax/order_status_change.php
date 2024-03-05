<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Application,
    Bitrix\Main\Context,
    Bitrix\Main\Request,
    Bitrix\Main\Server,
    Bitrix\Main\Loader,
    Bitrix\Highloadblock as HL,
    Bitrix\Main\Entity;

$context = Application::getInstance()->getContext();
$request = $context->getRequest();
$values = $request->getPostList();

if ($values['order_id'] && $values['stage_id'] && $values['status_value']) {

    Loader::includeModule("highloadblock");
    $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_STAGES)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    $data = array(
        "UF_STATUS" => $values['status_value'],
    );

    //обновляем статус у этапа
    $result = $entity_data_class::update($values['stage_id'], $data);

    if ($result) {

        //если статус = "на исполнении"
        if (intval($values['status_value']) === 9) {
            //ставим текущий этап у заказа
            CIBlockElement::SetPropertyValuesEx($values['order_id'], ACTIVE_ORDERS_IB_ID, array('CURRENT_STAGE' => $values['stage_id']));
        }

        if ($values['customer_id']) {

            //получаем название заказа
            Loader::includeModule("iblock");
            $res = CIBlockElement::GetByID($values['order_id']);
            if ($ar_res = $res->GetNext()) {
                $ORDER_NAME = $ar_res['NAME'];
            }
            $rsUser = CUser::GetByID($values['customer_id']);
            $arUser = $rsUser->Fetch();
            $USER_EMAIL = $arUser['EMAIL'];
            //получаем id типа работ
            $data = $entity_data_class::getList(array(
                "select" => array("UF_TYPE_OF_WORK_ID"),
                "order" => array("ID" => "DESC"),
                "filter" => array("ID" => $values['stage_id'])
            ));
            while ($arData = $data->Fetch()) {
                $TYPE_OF_WORK_ID = $arData["UF_TYPE_OF_WORK_ID"];
            }
            //получаем статус работы
            $obEnum = new \CUserFieldEnum;
            $rsEnum = $obEnum->GetList(array(), array("USER_FIELD_NAME" => 'UF_STATUS'));
            $enum = array();
            while ($arEnum = $rsEnum->Fetch()) {
                $enum[$arEnum["ID"]] = $arEnum["VALUE"];
            }
            if (!empty($enum) && $values['status_value']) {
                $NEW_STATUS = $enum[$values['status_value']];
            }
            if ($TYPE_OF_WORK_ID) {
                //получаем название этапа
                $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_TYPES_OF_WORK)->fetch();
                $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                $entity_data_class = $entity->getDataClass();
                $data = $entity_data_class::getList(array(
                    "select" => array("UF_NAME"),
                    "order" => array("ID" => "DESC"),
                    "filter" => array("ID" => $TYPE_OF_WORK_ID)
                ));
                while ($arData = $data->Fetch()) {
                    $STAGE_NAME = $arData['UF_NAME'];
                }
            }
            //если собрали все поля
            if ($values['from'] && $values['to'] && $STAGE_NAME && $ORDER_NAME && $USER_EMAIL && $NEW_STATUS) {
                //информируем пользователя о смене статуса
                sendDataToEmail(
                    'ORDER_STEP_STATUS_CHANGED',
                    $USER_EMAIL,
                    [
                        'STAGE_NAME' => $STAGE_NAME,
                        'ORDER_NAME' => $ORDER_NAME,
                        'NEW_STATUS' => $NEW_STATUS,
                        'FROM' => $values['from'],
                        'TO' => $values['to'],
                    ]);
            }
        }

        //проверяем прогресс заказа
        checkOrderProgress($values['order_id']);

    }
}