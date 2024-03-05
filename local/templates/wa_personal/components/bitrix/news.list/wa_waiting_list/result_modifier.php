<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

foreach ($arResult['ITEMS'] as &$item) {
    if (isset($item['PROPERTIES']) && !empty($item['PROPERTIES'])) {
        if (isset($item['PROPERTIES']['SERVICE_TYPE']['VALUE'])) {
            $res = CIBlockElement::GetList([], ["IBLOCK_ID" => SERVICE_IB_ID, 'ID' => $item['PROPERTIES']['SERVICE_TYPE']['VALUE']], false, [], ["NAME"]);
            while ($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();
                if ($arFields) {
                    $item['SERVICE_TYPE_NAME'] = $arFields["NAME"];
                }
            }
        }
        if (isset($item['PROPERTIES']['CUSTOMER']['VALUE'])) {
            $item['CUSTOMER_NAME'] = $item['PROPERTIES']['CUSTOMER']['VALUE'];
        }
        if (isset($item['PROPERTIES']['CONTACT_PERSON_ID']['VALUE'])) {
            $rsUser = CUser::GetByID($item['PROPERTIES']['CONTACT_PERSON_ID']['VALUE']);
            $arUser = $rsUser->Fetch();
            $item['CONTACT_PERSON'] = [
                'ID' => $arUser['ID'],
                'NAME' => $arUser['NAME'],
                'SECOND_NAME' => $arUser['SECOND_NAME'],
                'LAST_NAME' => $arUser['LAST_NAME'],
            ];
        }
    }
}