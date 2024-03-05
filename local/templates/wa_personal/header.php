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
    <?/* $APPLICATION->AddHeadScript('https://api-maps.yandex.ru/2.1/?'); */?>
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

<main class="lk">