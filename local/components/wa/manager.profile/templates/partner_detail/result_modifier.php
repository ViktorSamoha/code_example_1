<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($arParams['USER_ID']) {
    //формируем массив с данными заказчика
    $arResult['COUNTERPARTY'] = $arResult['PARTNERS_LIST'][$arParams['USER_ID']];
    if (!empty($arResult['COUNTERPARTY']['UF_USER_POST'])) {
        $arResult['COUNTERPARTY']['USER_POST'] = $arResult['USER_POST_LIST'][$arResult['COUNTERPARTY']['UF_USER_POST'][0]];
    }
    $arResult['COUNTERPARTY']['FIO'] = $arResult['COUNTERPARTY']['LAST_NAME'] . ' ' . $arResult['COUNTERPARTY']['NAME'] . ' ' . $arResult['COUNTERPARTY']['SECOND_NAME'];

    $arUserOrders = [];//массив со всеми заказами пользователя

    //достаем архивные заказы
    $arSelect = array("ID", "PROPERTY_SERVICE_ID");
    $arFilter = array("IBLOCK_ID" => ARCHIVE_ORDERS_IB_ID, "PROPERTY_CUSTOMER" => $arParams['USER_ID']);
    $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arUserOrders['ARCHIVE'][$arFields['ID']] = [
            'COMPANY_NAME' => $arResult['COUNTERPARTY']['WORK_COMPANY'],
            'FIO' => $arResult['COUNTERPARTY']['FIO'],
            'EMAIL' => $arResult['COUNTERPARTY']['EMAIL'],
            'PERSONAL_PHONE' => $arResult['COUNTERPARTY']['PERSONAL_PHONE'],
            'SERVICE_VALUE' => $arResult['SERVICE_LIST'][$arFields['PROPERTY_SERVICE_ID_VALUE']],
            'STATUS' => 'Завершен',
        ];
    }

    //достаем перечень статусов этапа заказа
    $rsType = CUserFieldEnum::GetList(array(), array(
        'USER_FIELD_NAME' => 'UF_STATUS',
    ));
    foreach ($rsType->arResult as $arType) {
        $arResult['STATUSES'][$arType['ID']] = [
            'ID' => $arType['ID'],
            'VALUE' => $arType['VALUE'],
        ];
    }

    //достаем перечень активных заказов
    $arSelect = array("ID", "PROPERTY_SERVICE_ID", "PROPERTY_CURRENT_STAGE");
    $arFilter = array("IBLOCK_ID" => ACTIVE_ORDERS_IB_ID, "PROPERTY_CUSTOMER" => $arParams['USER_ID']);
    $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arUserOrders['ACTIVE'][$arFields['ID']] = [
            'COMPANY_NAME' => $arResult['COUNTERPARTY']['WORK_COMPANY'],
            'FIO' => $arResult['COUNTERPARTY']['FIO'],
            'EMAIL' => $arResult['COUNTERPARTY']['EMAIL'],
            'PERSONAL_PHONE' => $arResult['COUNTERPARTY']['PERSONAL_PHONE'],
            'SERVICE_VALUE' => $arResult['SERVICE_LIST'][$arFields['PROPERTY_SERVICE_ID_VALUE']],
            'STATUS_VALUE' => $arResult['STATUSES'][$arFields['PROPERTY_CURRENT_STAGE_VALUE']]['VALUE'],
        ];
    }

    //достаем перечень заявок
    $arSelect = array("ID", "PROPERTY_SERVICE_TYPE");
    $arFilter = array("IBLOCK_ID" => WAITING_LIST_IB_ID, "PROPERTY_CONTACT_PERSON_ID" => $arParams['USER_ID']);
    $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arUserOrders['WAITING'][$arFields['ID']] = [
            'COMPANY_NAME' => $arResult['COUNTERPARTY']['WORK_COMPANY'],
            'FIO' => $arResult['COUNTERPARTY']['FIO'],
            'EMAIL' => $arResult['COUNTERPARTY']['EMAIL'],
            'PERSONAL_PHONE' => $arResult['COUNTERPARTY']['PERSONAL_PHONE'],
            'SERVICE_VALUE' => $arResult['SERVICE_LIST'][$arFields['PROPERTY_SERVICE_TYPE_VALUE']],
            'STATUS_VALUE' => 'В ожидании',
        ];
    }

    $userOrdersList = [];

    //формируем единый массив
    foreach ($arUserOrders as $orderType => $arOrders) {
        $userOrdersList = array_merge($userOrdersList, $arOrders);
    }
    //переворачиваем массив, в вид: заявки/активные заказы/завершенные заказы
    $userOrdersList = array_reverse($userOrdersList);

    //пагинация
    $rs_ObjectList = new CDBResult;
    $rs_ObjectList->InitFromArray($userOrdersList);
    $rs_ObjectList->NavStart(4, false);
    $arResult["NAV_STRING"] = $rs_ObjectList->GetPageNavString("", '');
    $arResult["PAGE_START"] = $rs_ObjectList->SelectedRowsCount() - ($rs_ObjectList->NavPageNomer - 1) * $rs_ObjectList->NavPageSize;
    while ($ar_Field = $rs_ObjectList->Fetch()) {
        $arResult['USER_ORDERS_LIST'][] = $ar_Field;
    }

} else {
    LocalRedirect("/personal/partners/");
}