<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Application,
    Bitrix\Main\Context,
    Bitrix\Main\Request,
    Bitrix\Main\Server,
    Bitrix\Main\Loader,
    Bitrix\Highloadblock as HL,
    Bitrix\Main\Entity;

$context = Application::getInstance()->getContext();
$request = $context->getRequest();
$values = $request->getPostList();
$element_id = $request->get("ID");
if ($element_id) {
    Loader::includeModule("iblock");
    $el = new CIBlockElement;
    $el->Update($element_id, ['ACTIVE' => 'N']);
}
