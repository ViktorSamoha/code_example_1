<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($arResult['DISPLAY_PROPERTIES']['GOALS']['DISPLAY_VALUE']) {
    $arResult['GOAL'] = $arResult['DISPLAY_PROPERTIES']['GOALS']['DISPLAY_VALUE'];
    //$arResult['DISPLAY_PROPERTIES']['GOALS']['DISPLAY_VALUE'] = modifierDetailText($arResult, 'GOAL');
}

$arResult['DETAIL_TEXT'] = modifierDetailText($arResult, 'DETAIL_TEXT');

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
