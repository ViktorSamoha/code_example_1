<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

//костыль на разделение строки
//в названии нужно поставить `\n`
if (isset($arResult['NAME']) && !empty($arResult['NAME'])) {
    $arResult['AR_NAME'] = explode('\n', $arResult['NAME']);
}
