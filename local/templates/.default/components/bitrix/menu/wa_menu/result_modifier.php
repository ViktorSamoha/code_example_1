<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

//переносим пункты меню в массив
foreach ($arResult as $iter => $arMenuItem) {
    $arResult['MENU'][] = $arMenuItem;
    unset($arResult[$iter]);
}

//достаем элементы инфоблока "Услуги" и формируем массив для 2 меню
$secondMenu = [];

CModule::IncludeModule('iblock');
$arSelect = array("ID", "NAME", "CODE");
$arFilter = array("IBLOCK_ID" => SERVICE_IB_ID, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
$res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $secondMenu[] = [
        'ID' => $arFields['ID'],
        'NAME' => $arFields['NAME'],
        'LINK' => '/service/' . $arFields['CODE'] . '/',
    ];
}

unset($arSelect, $arFilter, $res, $ob, $arFields);
$ecoMenu = [];
$arSelect = array("ID", "NAME", "CODE");
$arFilter = array("IBLOCK_ID" => ECO_DOC_IB_ID);
$res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    $ecoMenu[] = [
        'ID' => $arFields['ID'],
        'NAME' => $arFields['NAME'],
        'LINK' => '/ekologicheskaya-otchetnost/' . $arFields['CODE'] . '/',
    ];
}

if (!empty($ecoMenu)) {
    foreach ($secondMenu as &$menuItem) {
        if ($menuItem['ID'] == 15) {
            $menuItem['CHILDS'] = $ecoMenu;
        }
    }
}

$arResult['SECOND_MENU'] = $secondMenu;

