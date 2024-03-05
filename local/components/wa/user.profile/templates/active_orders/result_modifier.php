<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CModule::IncludeModule('iblock');
$arSelect = Array("ID", "NAME",);
$arFilter = Array("IBLOCK_ID"=>SERVICE_IB_ID, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
while($ob = $res->GetNextElement()){
    $arFields = $ob->GetFields();
    $arResult['SERVICES'][] = $arFields;
}