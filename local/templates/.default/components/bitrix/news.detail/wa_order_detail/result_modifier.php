<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
    Bitrix\Highloadblock as HL,
    Bitrix\Main\Entity;

if ($arParams["ARCHIVE_ORDER"]) {
    $arResult['ORDER_ID'] = $arResult['DISPLAY_PROPERTIES']['ORDER_ID']['VALUE'];
} else {
    $arResult['ORDER_ID'] = $arResult['ID'];
}

Loader::includeModule("highloadblock");
$hlblock = HL\HighloadBlockTable::getById(HLBLOCK_STAGES)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();
$data = $entity_data_class::getList(array(
    "select" => array("*"),
    "order" => array("ID" => "DESC"),
    "filter" => array(
        "UF_ORDER_ID" => $arResult['ORDER_ID'],
    )
));
$arStages = [];
while ($arData = $data->Fetch()) {
    $status = null;
    $arStatus = [];
    $rsType = CUserFieldEnum::GetList(array(), array(
        'USER_FIELD_NAME' => 'UF_STATUS',
    ));
    foreach ($rsType->arResult as $arType) {
        $arStatus[$arType['ID']] = $arType;
    }
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

if (!empty($arStages)) {
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
}
if (!empty($arStages)) {
    $arResult['STAGES'] = $arStages;
}

if (isset($arResult['DISPLAY_PROPERTIES']['EXECUTOR']['VALUE']) && !empty($arResult['DISPLAY_PROPERTIES']['EXECUTOR']['VALUE'])) {
    global $USER;
    $rsUser = CUser::GetByID($arResult['DISPLAY_PROPERTIES']['EXECUTOR']['VALUE']);
    $arExecutor = $rsUser->Fetch();
    $arResult['EXECUTOR'] = [
        'ID' => $arExecutor['ID'],
        'LAST_NAME' => $arExecutor['LAST_NAME'],
        'NAME' => $arExecutor['NAME'],
        'SECOND_NAME' => $arExecutor['SECOND_NAME'],
        'PERSONAL_PHONE' => $arExecutor['PERSONAL_PHONE'],
        'TELEGRAM' => $arExecutor['UF_TELEGRAM_LINK'],
        'WHATSAPP' => $arExecutor['UF_WHATSAPP_LINK'],
        'PERSONAL_PHOTO' => CFile::GetPath($arExecutor["PERSONAL_PHOTO"]),
    ];
}

if (isset($arResult['DISPLAY_PROPERTIES']['DOCS']['VALUE']) && !empty($arResult['DISPLAY_PROPERTIES']['DOCS']['VALUE'])) {
    foreach ($arResult['DISPLAY_PROPERTIES']['DOCS']['VALUE'] as $docId) {
        $arResult['DOCS'][] = CFile::GetFileArray($docId);
    }
}

if (isset($arResult['DISPLAY_PROPERTIES']['CUSTOMER']['VALUE']) && !empty($arResult['DISPLAY_PROPERTIES']['CUSTOMER']['VALUE'])) {
    global $USER;
    $rsUser = CUser::GetByID($arResult['DISPLAY_PROPERTIES']['CUSTOMER']['VALUE']);
    $arCustomer = $rsUser->Fetch();
    $arResult['CUSTOMER'] = [
        'ID' => $arCustomer['ID'],
        'LAST_NAME' => $arCustomer['LAST_NAME'],
        'NAME' => $arCustomer['NAME'],
        'SECOND_NAME' => $arCustomer['SECOND_NAME'],
        'PERSONAL_PHONE' => $arCustomer['PERSONAL_PHONE'],
        'TELEGRAM' => $arCustomer['UF_TELEGRAM_LINK'],
        'WHATSAPP' => $arCustomer['UF_WHATSAPP_LINK'],
        'PERSONAL_PHOTO' => CFile::GetPath($arCustomer["PERSONAL_PHOTO"]),
        'WORK_COMPANY' => $arCustomer['WORK_COMPANY'],
    ];
}
