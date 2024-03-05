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

$APPLICATION->SetTitle($arResult['COUNTERPARTY']['WORK_COMPANY']);

?>
<? if (isset($arResult['COUNTERPARTY']) && !empty($arResult['COUNTERPARTY'])): ?>
    <div class="table-wrap">
        <table class="table-info">
            <tr>
                <th>Компания</th>
                <td><?= $arResult['COUNTERPARTY']['WORK_COMPANY'] ?></td>
            </tr>
            <tr>
                <th>ФИО</th>
                <td><?= $arResult['COUNTERPARTY']['FIO'] ?></td>
            </tr>
            <tr>
                <th>Должность</th>
                <td><?= $arResult['COUNTERPARTY']['USER_POST']['NAME'] ?></td>
            </tr>
            <tr>
                <th>Телефон</th>
                <td><?= $arResult['COUNTERPARTY']['PERSONAL_PHONE'] ?></td>
            </tr>
            <tr>
                <th>E-mail</th>
                <td><?= $arResult['COUNTERPARTY']['EMAIL'] ?></td>
            </tr>
        </table>
    </div>
<? endif; ?>
    <h3 class="h3">Заказы контрагента</h3>
<? if (isset($arResult['USER_ORDERS_LIST']) && !empty($arResult['USER_ORDERS_LIST'])): ?>
    <div class="table-wrap">
        <table class="table">
            <tr>
                <th>Название компании</th>
                <th>ФИО</th>
                <th>e-mail</th>
                <th>Телефон</th>
                <th>Заказ</th>
                <th>Статус заказа</th>
            </tr>
            <? foreach ($arResult['USER_ORDERS_LIST'] as $userOrder): ?>
                <tr>
                    <td><?= $userOrder['COMPANY_NAME'] ?></td>
                    <td class="text-center"><?= $userOrder['FIO'] ?></td>
                    <td><?= $userOrder['EMAIL'] ?></td>
                    <td class="text-center" style="white-space:nowrap"><?= $userOrder['PERSONAL_PHONE'] ?></td>
                    <td><?= $userOrder['SERVICE_VALUE']['NAME'] ?></td>
                    <td class="text-center"><?= $userOrder['STATUS'] ?></td>
                </tr>
            <? endforeach; ?>
        </table>
    </div>
<? endif; ?>

<?= $arResult['NAV_STRING'] ?>