<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

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

$iblockId = ACTIVE_ORDERS_IB_ID;
$propertyCodes = [
    0 => "CUSTOMER",
    1 => "EXECUTOR",
    2 => "STATUS",
    3 => "STAGES",
    4 => "DOCS",
];
$archiveOrder = false;

if (isset($_REQUEST["arch"])) {
    if ($_REQUEST["arch"] == 'Y') {
        $iblockId = ARCHIVE_ORDERS_IB_ID;
        $propertyCodes = [
            0 => "CUSTOMER",
            1 => "EXECUTOR",
            2 => "SERVICE_ID",
            3 => "ORDER_ID",
            4 => "DOCS",
        ];
        $archiveOrder = true;
    }
}

$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "wa_order_detail",
    array(
        "ACTIVE_DATE_FORMAT" => "d.m.Y",    // Формат показа даты
        "ADD_ELEMENT_CHAIN" => "N",    // Включать название элемента в цепочку навигации
        "ADD_SECTIONS_CHAIN" => "Y",    // Включать раздел в цепочку навигации
        "AJAX_MODE" => "N",    // Включить режим AJAX
        "AJAX_OPTION_ADDITIONAL" => "",    // Дополнительный идентификатор
        "AJAX_OPTION_HISTORY" => "N",    // Включить эмуляцию навигации браузера
        "AJAX_OPTION_JUMP" => "N",    // Включить прокрутку к началу компонента
        "AJAX_OPTION_STYLE" => "N",    // Включить подгрузку стилей
        "BROWSER_TITLE" => "-",    // Установить заголовок окна браузера из свойства
        "CACHE_GROUPS" => "Y",    // Учитывать права доступа
        "CACHE_TIME" => "36000000",    // Время кеширования (сек.)
        "CACHE_TYPE" => "N",    // Тип кеширования
        "CHECK_DATES" => "Y",    // Показывать только активные на данный момент элементы
        "DETAIL_URL" => "",    // URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
        "DISPLAY_BOTTOM_PAGER" => "N",    // Выводить под списком
        "DISPLAY_DATE" => "N",    // Выводить дату элемента
        "DISPLAY_NAME" => "N",    // Выводить название элемента
        "DISPLAY_PICTURE" => "N",    // Выводить детальное изображение
        "DISPLAY_PREVIEW_TEXT" => "N",    // Выводить текст анонса
        "DISPLAY_TOP_PAGER" => "N",    // Выводить над списком
        "ELEMENT_CODE" => "",    // Код новости
        "ELEMENT_ID" => $_REQUEST["id"],    // ID новости
        "FIELD_CODE" => array(    // Поля
            0 => "ID",
            1 => "NAME",
            2 => "",
        ),
        "IBLOCK_ID" => $iblockId,    // Код информационного блока
        "IBLOCK_TYPE" => "orders",    // Тип информационного блока (используется только для проверки)
        "IBLOCK_URL" => "",    // URL страницы просмотра списка элементов (по умолчанию - из настроек инфоблока)
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",    // Включать инфоблок в цепочку навигации
        "MESSAGE_404" => "",    // Сообщение для показа (по умолчанию из компонента)
        "META_DESCRIPTION" => "-",    // Установить описание страницы из свойства
        "META_KEYWORDS" => "-",    // Установить ключевые слова страницы из свойства
        "PAGER_BASE_LINK_ENABLE" => "N",    // Включить обработку ссылок
        "PAGER_SHOW_ALL" => "N",    // Показывать ссылку "Все"
        "PAGER_TEMPLATE" => ".default",    // Шаблон постраничной навигации
        "PAGER_TITLE" => "Страница",    // Название категорий
        "PROPERTY_CODE" => $propertyCodes,
        "SET_BROWSER_TITLE" => "Y",    // Устанавливать заголовок окна браузера
        "SET_CANONICAL_URL" => "N",    // Устанавливать канонический URL
        "SET_LAST_MODIFIED" => "N",    // Устанавливать в заголовках ответа время модификации страницы
        "SET_META_DESCRIPTION" => "Y",    // Устанавливать описание страницы
        "SET_META_KEYWORDS" => "Y",    // Устанавливать ключевые слова страницы
        "SET_STATUS_404" => "N",    // Устанавливать статус 404
        "SET_TITLE" => "Y",    // Устанавливать заголовок страницы
        "SHOW_404" => "N",    // Показ специальной страницы
        "STRICT_SECTION_CHECK" => "N",    // Строгая проверка раздела для показа элемента
        "USE_PERMISSIONS" => "N",    // Использовать дополнительное ограничение доступа
        "USE_SHARE" => "N",    // Отображать панель соц. закладок
        "ARCHIVE_ORDER" => $archiveOrder,
    ),
    false
);
?>
