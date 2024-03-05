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

$APPLICATION->SetTitle("Контрагенты");

?>
<div class="table-wrap">
    <table class="table">
        <tr>
            <th>Название компании</th>
            <th>ФИО</th>
            <th>e-mail</th>
            <th>Телефон</th>
            <th>Заказ</th>
            <th>Статус заказа</th>
            <th></th>
        </tr>
        <? foreach ($arResult['PARTNERS_LIST'] as $partner): ?>
            <tr>
                <td><?= $partner['WORK_COMPANY'] ?></td>
                <td class="text-center"><?= $partner['LAST_NAME'] . ' ' . $partner['NAME'] . ' ' . $partner['SECOND_NAME'] ?></td>
                <td><?= $partner['EMAIL'] ?></td>
                <td class="text-center" style="white-space:nowrap"><?= $partner['PERSONAL_PHONE'] ?></td>
                <td><?= $partner['LAST_ORDER']['NAME'] ?></td>
                <td class="text-center"><?= $partner['LAST_ORDER']['STATUS'] ?></td>
                <td class="text-center">
                    <a href="/personal/partner/?id=<?= $partner['ID'] ?>">Подробнее</a>
                </td>
            </tr>
        <? endforeach; ?>
    </table>
</div>