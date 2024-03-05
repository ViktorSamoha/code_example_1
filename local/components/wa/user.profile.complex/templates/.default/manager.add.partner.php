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

$APPLICATION->IncludeComponent(
    "wa:manager.profile",
    "add_user",
    [
        'ADD_TITLE' => true,
        'IS_PARTNER' => true,
        'FORM_ID' => 'form-registration-partner',
        'FORM_BTN_ID' => 'create-partner',
    ],
    false
);
?>
