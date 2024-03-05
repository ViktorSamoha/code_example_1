<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (isset($arResult['USER']['UF_USER_MAILING']) && !empty($arResult['USER']['UF_USER_MAILING'])) {
    foreach ($arResult['USER']['UF_USER_MAILING'] as $selectedPropId) {
        foreach ($arResult['USER_MAILING_LIST'] as $propId => $propName) {
            if ($propId == $selectedPropId) {
                $arResult['USER_MAILING_LIST'][$propId]['CHECKED'] = true;
            }
        }
    }
}