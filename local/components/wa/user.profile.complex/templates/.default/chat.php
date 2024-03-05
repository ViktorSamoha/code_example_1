<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader,
    Bitrix\Highloadblock as HL,
    Bitrix\Main\Entity;

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

$order_id = null;
$session = \Bitrix\Main\Application::getInstance()->getSession();
if (!$session->has('chat_order_id')) {
    if ($_REQUEST['order_id']) {
        $session->set('chat_order_id', $_REQUEST['order_id']);
        $order_id = $_REQUEST['order_id'];
    }
} else {
    if ($_REQUEST['order_id']) {
        if ($session['chat_order_id'] != $_REQUEST['order_id']) {
            $session->set('chat_order_id', $_REQUEST['order_id']);
        }
    }
    $order_id = $session['chat_order_id'];
}

$manager_id = null;
Loader::includeModule("iblock");
$res = CIBlockElement::GetList(["ID" => "DESC"], ["IBLOCK_ID" => ACTIVE_ORDERS_IB_ID, "ID" => $order_id], false, [], ["PROPERTY_EXECUTOR"]);
while ($ob = $res->GetNextElement()) {
    $arFields = $ob->GetFields();
    if ($arFields && isset($arFields['PROPERTY_EXECUTOR_VALUE'])) {
        $manager_id = $arFields['PROPERTY_EXECUTOR_VALUE'];
    }
}

$APPLICATION->IncludeComponent(
    "wa:chat",
    "",
    [
        'ORDER_ID' => $order_id,
        'MANAGER_ID' => $manager_id,
    ],
    false
);


?>
