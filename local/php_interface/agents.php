<?php

use Bitrix\Main\Application,
    Bitrix\Main\Context,
    Bitrix\Main\Request,
    Bitrix\Main\Server,
    Bitrix\Main\Loader,
    Bitrix\Highloadblock as HL,
    Bitrix\Main\Entity;

//агент, который смотрит неактивные заявки и снова их активирует
function checkUserRequestStatus()
{
    Loader::includeModule("iblock");
    $curTime = new DateTime();
    $arSelect = array("ID", "NAME", "TIMESTAMP_X");
    $arFilter = array("IBLOCK_ID" => WAITING_LIST_IB_ID, "ACTIVE" => "N");
    $res = CIBlockElement::GetList([], $arFilter, false, [], $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        if ($arFields) {
            $timestamp = new DateTime($arFields['TIMESTAMP_X']);
            $interval = $timestamp->diff($curTime);
            if ($interval->d != 0) {
                $el = new CIBlockElement;
                $res = $el->Update($arFields['ID'], ["ACTIVE" => "Y",]);
                if (!$res) {
                    $error_msg = $curTime->format('d.m.Y H:i:s') . ' Ошибка активации заявки id=' . $arFields['ID'];
                    \Bitrix\Main\Diag\Debug::dumpToFile($error_msg, $varName = 'checkUserRequestStatus', $fileName = 'agent_error_log.txt');
                }
            } else {
                if ($interval->i >= 15) {
                    $el = new CIBlockElement;
                    $res = $el->Update($arFields['ID'], ["ACTIVE" => "Y",]);
                    if (!$res) {
                        $error_msg = $curTime->format('d.m.Y H:i:s') . ' Ошибка активации заявки id=' . $arFields['ID'];
                        \Bitrix\Main\Diag\Debug::dumpToFile($error_msg, $varName = 'checkUserRequestStatus', $fileName = 'agent_error_log.txt');
                    }
                }
            }
        }
    }
    return 'checkUserRequestStatus();';
}