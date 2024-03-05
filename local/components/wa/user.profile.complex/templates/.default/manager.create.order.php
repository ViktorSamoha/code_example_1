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

if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
    $user_id = $_REQUEST['id'];
}
if (isset($_REQUEST['service']) && !empty($_REQUEST['service'])) {
    $service_id = $_REQUEST['service'];
}

$APPLICATION->IncludeComponent(
    "wa:manager.profile",
    "create_order",
    [
        'USER_ID' => $user_id ?? '',
        'SERVICE_ID' => $service_id ?? '',
    ],
    false
);
?>
