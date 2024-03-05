<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

$APPLICATION->SetTitle("Архив заказов");
?>
<div class="table-wrap">
    <table class="table table--color-reverse">
        <tr>
            <th>№ заказа</th>
            <th>Вид услуги</th>
            <th>Статус</th>
            <th></th>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_green">Завершено</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_green">Завершено</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_green">Завершено</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_green">Завершено</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_green">Завершено</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_green">Завершено</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_green">Завершено</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_green">Завершено</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_green">Завершено</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_green">Завершено</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
    </table>
</div>

<nav class="page-nav">
    <div class="page-nav_left">
        <a href="#" class="page-nav_btn">
            <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M6.75414 9.35351L14.9982 1.10949L14.1211 0.232422L5 9.35351L14.1211 18.4746L14.9982 17.5975L6.75414 9.35351Z"
                      fill="#DE6396"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M1.75414 9.35351L9.99816 1.10949L9.12109 0.232422L0 9.35351L9.12109 18.4746L9.99816 17.5975L1.75414 9.35351Z"
                      fill="#DE6396"/>
            </svg>

        </a>
        <a href="#" class="page-nav_btn">
            <svg width="10" height="19" viewBox="0 0 10 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M1.75414 9.35351L9.99816 1.10949L9.12109 0.232422L0 9.35351L9.12109 18.4746L9.99816 17.5975L1.75414 9.35351Z"
                      fill="#DE6396"/>
            </svg>
        </a>
        <a href="#" class="page-nav_item active">1</a>
        <a href="#" class="page-nav_item">2</a>
        <a href="#" class="page-nav_item">3</a>
        <span class="page-nav_separator">...</span>
        <a href="#" class="page-nav_item">8</a>
        <a href="#" class="page-nav_item">9</a>
        <a href="#" class="page-nav_btn">
            <svg width="10" height="19" viewBox="0 0 10 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M8.24402 9.35351L0 1.10949L0.87707 0.232422L9.99816 9.35351L0.87707 18.4746L0 17.5975L8.24402 9.35351Z"
                      fill="#DE6396"/>
            </svg>
        </a>
        <a href="#" class="page-nav_btn">
            <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M8.24402 9.35351L0 1.10949L0.87707 0.232422L9.99816 9.35351L0.87707 18.4746L0 17.5975L8.24402 9.35351Z"
                      fill="#DE6396"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M13.244 9.35351L5 1.10949L5.87707 0.232422L14.9982 9.35351L5.87707 18.4746L5 17.5975L13.244 9.35351Z"
                      fill="#DE6396"/>
            </svg>
        </a>
    </div>
    <div class="page-nav_right">
        <div class="page-nav_info">Страница 1 (9)</div>
        <a href="#" class="page-nav_all">Показать все</a>
    </div>
</nav>