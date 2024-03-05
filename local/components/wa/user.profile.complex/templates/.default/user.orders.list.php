<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

if ($_REQUEST['filter'] == 'Y') {
    if ($_REQUEST['active'] == 'Y') {
        $arFilter['ORDER_TYPE'] = 'active';
    }
    if ($_REQUEST['arch'] == 'Y') {
        $arFilter['ORDER_TYPE'] = 'arch';
    }
    if ($_REQUEST['wait'] == 'Y') {
        $arFilter['ORDER_TYPE'] = 'wait';
    }
}

$APPLICATION->IncludeComponent(
    "wa:user.profile",
    "orders_list",
    [
        'FILTER' => $arFilter ?? '',
    ],
    false
);
?>
