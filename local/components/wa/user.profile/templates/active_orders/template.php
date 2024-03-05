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

$APPLICATION->SetTitle("Заказы на исполнении");
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
            <td class="text-center bg_light-blue">На исполнении</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_light-blue">На исполнении</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_light-blue">На исполнении</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
        <tr>
            <td class="text-center">ПМ1333789</td>
            <td>Производственный экологический контроль (ПЭК)</td>
            <td class="text-center bg_light-blue">На исполнении</td>
            <td class="text-center">
                <a href="#">Подробнее</a>
            </td>
        </tr>
    </table>
</div>
<!--<script>
    window.addEventListener("load", (event) => {
        let user = new User(<?/*=CUtil::PhpToJSObject($arResult['USER'])*/?>);
        user.init();
    });
</script>-->