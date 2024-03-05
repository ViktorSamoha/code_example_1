<?php

use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

use Bitrix\Main\Diag\Debug;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class WAChat extends CBitrixComponent implements Controllerable
{
    public function configureActions()
    {
        $this->errorCollection = new ErrorCollection();

        return [
            'insertMessage' => [
                'prefilters' => [],
            ],

        ];
    }

    public function insertMessageAction(): AjaxJson
    {
        $post = $this->request->getPostList()->toArray();
        if (!empty($post)) {
            if ($post['user_id'] && $post['message']) {
                $returnValue = null;
                Loader::includeModule("highloadblock");
                $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_CHAT)->fetch();
                $entity = HL\HighloadBlockTable::compileEntity($hlblock);
                $entity_data_class = $entity->getDataClass();

                $date = date('d.m.Y H:i:s');

                $data = array(
                    "UF_SENDER" => $post['user_id'],
                    "UF_TEXT" => $post['message'],
                    "UF_INSERT_DATE" => $date,
                    "UF_ORDER_ID" => $post['order_id'],
                    "UF_MANAGER_ID" => $post['manager_id'],
                    "UF_USER_ID" => $post['user_id'],
                );
                $result = $entity_data_class::add($data);
                if ($result->isSuccess()) {
                    $returnValue = ['action' => 'reload'];
                    return AjaxJson::createSuccess($returnValue);
                } else {
                    return AjaxJson::createError(null, 'Ошибка: ' . implode(', ', $result->getErrors()));
                }
            } else {
                return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
            }
        } else {
            return AjaxJson::createError(null, 'Ошибка - отсутствуют значения');
        }
    }

    public function getChatStructure()
    {
        global $USER;
        $orderId = $this->arParams['ORDER_ID'];
        $userId = $USER->GetID();
        $arMessages = [];
        if ($orderId) {
            Loader::includeModule("highloadblock");
            $hlblock = HL\HighloadBlockTable::getById(HLBLOCK_CHAT)->fetch();
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entity_data_class = $entity->getDataClass();
            $data = $entity_data_class::getList(array(
                "select" => array("*"),
                "order" => array("UF_INSERT_DATE" => "ASC"),
                "filter" => array(
                    "UF_ORDER_ID" => $orderId,
                    //"UF_SENDER" => $userId,
                )
            ));
            while ($arData = $data->Fetch()) {
                $arMessages[] = [
                    'SENDER' => $arData['UF_SENDER'],
                    'INSERT_DATE' => $arData['UF_INSERT_DATE']->format('d.m.Y H:i'),
                    'TEXT' => $arData['UF_TEXT'],
                ];
            }
            if (!empty($arMessages)) {
                foreach ($arMessages as &$message) {
                    if (isset($message['SENDER']) && !empty($message['SENDER'])) {
                        $rsUser = CUser::GetByID($message['SENDER']);
                        $arUser = $rsUser->Fetch();
                        $message['SENDER'] = [
                            'ID' => $message['SENDER'],
                            'NAME' => $arUser['NAME'],
                            'LAST_NAME' => $arUser['LAST_NAME'],
                            'SECOND_NAME' => $arUser['SECOND_NAME'],
                        ];
                    }
                }
            }
            if (!empty($arMessages)) {
                return $arMessages;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function init()
    {
        $this->arResult['CHAT_STRUCTURE'] = $this->getChatStructure();
    }

    public function executeComponent()
    {

        $this->init();

        $this->IncludeComponentTemplate($this->componentPage);

    }
}