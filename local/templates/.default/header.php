<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8"/>
    <? $APPLICATION->ShowHead() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><? $APPLICATION->ShowTitle() ?></title>
    <? $APPLICATION->SetAdditionalCSS(ASSETS . "css/flatpickr.min.css"); ?>
    <? $APPLICATION->SetAdditionalCSS(ASSETS . "css/main.css"); ?>
    <? $APPLICATION->SetAdditionalCSS("/local/templates/.default/assets/css/custom.css"); ?>
    <? // $APPLICATION->AddHeadScript(ASSETS . ''); ?>
</head>

<body>

<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>


<div class="preloader active">
    <div class="preloader-icon">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>

<? $APPLICATION->IncludeComponent(
    "bitrix:menu",
    "wa_menu",
    array(
        "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
        "CHILD_MENU_TYPE" => "top",    // Тип меню для остальных уровней
        "DELAY" => "N",    // Откладывать выполнение шаблона меню
        "MAX_LEVEL" => "1",    // Уровень вложенности меню
        "MENU_CACHE_GET_VARS" => array(    // Значимые переменные запроса
            0 => "",
        ),
        "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
        "MENU_CACHE_TYPE" => "A",    // Тип кеширования
        "MENU_CACHE_USE_GROUPS" => "N",    // Учитывать права доступа
        "ROOT_MENU_TYPE" => "top",    // Тип меню для первого уровня
        "USE_EXT" => "Y",    // Подключать файлы с именами вида .тип_меню.menu_ext.php
    ),
    false
); ?>
<? if (!defined("ERROR_404")): ?>
    <header class="i-header">
        <div class="i-header_left">
            <button class="nav-btn">
                <span class="nav-btn_line"></span>
                <span class="nav-btn_line"></span>
                <span class="nav-btn_line"></span>
            </button>

            <? $APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                "wa_nav",
                array(
                    "PATH" => "",
                    "SITE_ID" => "s1",
                    "START_FROM" => "0"
                )
            ); ?>

        </div>
        <div class="i-header_right">
            <form action="/search/" class="search-form">
                <input class="search-form_input" name="q" type="text" placeholder="Поиск">
                <button class="search-form_btn">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M17.8568 16.2345L13.203 11.5807C14.0782 10.377 14.5958 8.8965 14.5958 7.2975C14.5958 3.27375 11.322 0 7.2975 0C3.27375 0 0 3.27375 0 7.2975C0 11.322 3.27375 14.595 7.2975 14.595C8.823 14.595 10.2397 14.1247 11.4128 13.3215L16.0912 18L17.8568 16.2345ZM2.1405 7.2975C2.1405 4.4535 4.45425 2.13975 7.29825 2.13975C10.1423 2.13975 12.456 4.4535 12.456 7.2975C12.456 10.1415 10.1423 12.4552 7.29825 12.4552C4.4535 12.4552 2.1405 10.1415 2.1405 7.2975Z"
                                fill="#DE6396"/>
                    </svg>
                </button>
            </form>
            <div class="user">
                <a href="#" class="user_icon">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M4.5 4.26316C4.5 6.61358 6.519 8.52632 9 8.52632C11.481 8.52632 13.5 6.61358 13.5 4.26316C13.5 1.91274 11.481 0 9 0C6.519 0 4.5 1.91274 4.5 4.26316ZM17 18H18V17.0526C18 13.3967 14.859 10.4211 11 10.4211H7C3.14 10.4211 0 13.3967 0 17.0526V18H17Z"
                                fill="#DE6396"/>
                    </svg>
                </a>
                <div class="user_text">
                    <span class="user_name">Владислав</span>
                    <a href="#" class="user_logout">Выйти</a>
                </div>
            </div>
        </div>
    </header>
<? else: ?>
    <header class="header">
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => "/includes/index/header_contacts.php"
            )
        );
        ?>
    </header>
<? endif; ?>
<main class="inner inner--gray">