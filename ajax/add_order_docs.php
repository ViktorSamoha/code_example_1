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

CModule::IncludeModule('iblock');

if (!empty($_FILES["ORDER_DOC"])) {

    $arDocs = [];
    if (isset($values['ORDER_ID'])) {
        $orderDocs = array();
        $res = CIBlockElement::GetProperty(ACTIVE_ORDERS_IB_ID, $values['ORDER_ID'], "sort", "asc", array("CODE" => "DOCS"));
        while ($ob = $res->GetNext()) {
            $orderDocs[] = $ob['VALUE'];
        }
    }
    if (!empty($orderDocs)) {
        foreach ($orderDocs as $orderDocId) {
            $arDocs[] = ['VALUE' => CFile::MakeFileArray($orderDocId), 'DESCRIPTION' => 'doc'];
        }
    }

    $fileId = CFile::SaveFile($_FILES["ORDER_DOC"], 'order_docs');
    $arFile = CFile::MakeFileArray($fileId);

    $arDocs[] = ['VALUE' => $arFile, 'DESCRIPTION' => 'doc'];

    if ($arFile && $values['ORDER_ID']) {
        $prop['DOCS'] = $arDocs;
        $result = CIBlockElement::SetPropertyValuesEx($values['ORDER_ID'], ACTIVE_ORDERS_IB_ID, $prop);
        if ($result == null) {
            echo 'Документ успешно добавлен';
        }
    }
}