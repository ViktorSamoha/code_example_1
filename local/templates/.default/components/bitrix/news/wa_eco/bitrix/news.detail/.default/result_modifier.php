<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

//Достаем значения свойств
if (isset($arParams['IBLOCK_ELEMENT_ID'])) {
    $arSelect = array("NAME", "PROPERTY_BTN_SIGNATURE", "DETAIL_PICTURE", 'PROPERTY_ICON');
    $arFilter = array("IBLOCK_ID" => SERVICE_IB_ID, "ID" => $arParams['IBLOCK_ELEMENT_ID']);
    $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        if ($arFields) {
            /*$arResult['SECTION']['NAME'] = $arFields['NAME'];
            $arResult['SECTION']['BTN_SIGNATURE'] = $arFields['PROPERTY_BTN_SIGNATURE_VALUE'];
            $arResult['SECTION']['DETAIL_PICTURE'] = CFile::GetPath($arFields['DETAIL_PICTURE']);*/
            $arResult['DETAIL_PICTURE']['SRC'] = CFile::GetPath($arFields['DETAIL_PICTURE']);
            $arResult['DISPLAY_PROPERTIES']['ICON']['FILE_VALUE']['SRC'] = CFile::GetPath($arFields['PROPERTY_ICON_VALUE']);
        }
    }
}

/*if ($arResult['DISPLAY_PROPERTIES']['SERVICES']) {
    $arServices = [];
    foreach ($arResult['DISPLAY_PROPERTIES']['SERVICES']['DESCRIPTION'] as $k => $serviceTitle) {
        $arServices[$k]['TITLE'] = $serviceTitle;
    }
    unset($k);
    foreach ($arResult['DISPLAY_PROPERTIES']['SERVICES']['DISPLAY_VALUE'] as $k => $serviceText) {
        $arServices[$k]['VALUE'] = $serviceText;
    }
    if (!empty($arServices)) {
        $arResult['SERVICES'] = $arServices;
    }
}*/