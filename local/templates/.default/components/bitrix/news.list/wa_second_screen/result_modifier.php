<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult['ITEMS'] as $i=>&$item) {
    if($item['IBLOCK_SECTION_ID'] != null){
        unset($arResult['ITEMS'][$i]);
    }
    if (isset($item['DISPLAY_PROPERTIES']['ICON']) && !empty($item['DISPLAY_PROPERTIES']['ICON'])) {
        $item['ICON'] = $item['DISPLAY_PROPERTIES']['ICON']['FILE_VALUE']['SRC'];
    }
}