<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
$arParams['USE_SHARE'] = (string)($arParams['USE_SHARE'] ?? 'N');
$arParams['USE_SHARE'] = $arParams['USE_SHARE'] === 'Y' ? 'Y' : 'N';
$arParams['SHARE_HIDE'] = (string)($arParams['SHARE_HIDE'] ?? 'N');
$arParams['SHARE_HIDE'] = $arParams['SHARE_HIDE'] === 'Y' ? 'Y' : 'N';
$arParams['SHARE_TEMPLATE'] = (string)($arParams['SHARE_TEMPLATE'] ?? 'N');
$arParams['SHARE_HANDLERS'] ??= [];
$arParams['SHARE_HANDLERS'] = is_array($arParams['SHARE_HANDLERS']) ? $arParams['SHARE_HANDLERS'] : [];
$arParams['SHARE_SHORTEN_URL_LOGIN'] = (string)($arParams['SHARE_SHORTEN_URL_LOGIN'] ?? 'N');
$arParams['SHARE_SHORTEN_URL_KEY'] = (string)($arParams['SHARE_SHORTEN_URL_KEY'] ?? 'N');

//Достаем значения свойств
if (isset($arParams['IBLOCK_ELEMENT_ID'])) {
    $arSelect = array("NAME", "PROPERTY_BTN_SIGNATURE", "PROPERTY_GOALS", "DETAIL_PICTURE");
    $arFilter = array("IBLOCK_ID" => SERVICE_IB_ID, "ID" => $arParams['IBLOCK_ELEMENT_ID']);
    $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        if ($arFields) {
            $arResult['NAME'] = $arFields['NAME'];
            $arResult['BTN_SIGNATURE'] = $arFields['PROPERTY_BTN_SIGNATURE_VALUE'];
            $arResult['DETAIL_PICTURE'] = CFile::GetPath($arFields['DETAIL_PICTURE']);
            $arResult['GOALS'] = html_entity_decode($arFields['PROPERTY_GOALS_VALUE']['TEXT'], ENT_QUOTES | ENT_SUBSTITUTE);
        }
    }
}