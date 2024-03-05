<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
IncludeTemplateLangFile(__FILE__);
?>
<html>
<head>
    <meta charset="UTF-8"/>
    <? $APPLICATION->ShowHead() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><? $APPLICATION->ShowTitle() ?></title>
    <? $APPLICATION->SetAdditionalCSS(ASSETS . "css/flatpickr.min.css"); ?>
    <? $APPLICATION->SetAdditionalCSS(ASSETS . "css/main.css"); ?>

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

<div class="navbar">
    <button class="nav-btn">
        <span class="nav-btn_line"></span>
        <span class="nav-btn_line"></span>
        <span class="nav-btn_line"></span>
    </button>
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

<header class="header header--bg">
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

<div class="main-bg">
    <video loop autoplay muted -webkit-playsinline playsinline>
        <source src="<?= ASSETS ?>video/main.mp4" type="video/mp4"/>
    </video>
</div>

<main class="main">