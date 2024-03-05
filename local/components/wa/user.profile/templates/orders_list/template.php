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

$APPLICATION->SetTitle("Мои заказы");
$user = getUserData();

$activeTab = 'all';

if ($_REQUEST['filter'] == 'Y') {
    if ($_REQUEST['active'] == 'Y') {
        $activeTab = 'active';
    } else if ($_REQUEST['arch'] == 'Y') {
        $activeTab = 'arch';
    } else if ($_REQUEST['wait'] == 'Y') {
        $activeTab = 'wait';
    } else {
        $activeTab = 'all';
    }
}

?>
<div class="tabs">
    <div class="tabs-content">
        <div class="tabs-content_item active" data-name="tab_03">
            <div class="filter">
                <button class="filter_btn <?= $activeTab == 'all' ? 'active' : '' ?>" data-action="all">Все</button>
                <? if ($user['IS_SIMPLE_USER']): ?>
                    <button class="filter_btn <?= $activeTab == 'wait' ? 'active' : '' ?>" data-action="wait">Заявки
                    </button>
                <? endif; ?>
                <button class="filter_btn <?= $activeTab == 'active' ? 'active' : '' ?>" data-action="active">Активные
                </button>
                <button class="filter_btn <?= $activeTab == 'arch' ? 'active' : '' ?>" data-action="arch">Архив</button>
            </div>
            <? if ($user['IS_SIMPLE_USER']): ?>
                <div class="table-wrap">
                    <table class="table table--color-reverse">
                        <tr>
                            <th>№ заказа</th>
                            <th>Вид услуги</th>
                            <th>Статус</th>
                            <th></th>
                        </tr>
                        <? foreach ($arResult['USER_ORDERS_LIST'] as $order): ?>
                            <tr>
                                <td class="text-center"><?= $order['ID'] ?></td>
                                <td><?= $order['SERVICE_TYPE'] ?></td>
                                <td class="text-center"><?= $order['STATUS'] ?></td>
                                <? if ($order['TYPE'] == 'order'): ?>
                                    <td class="text-center">
                                        <a href="/personal/order_detail/?id=<?= $order['ID'] ?>">Подробнее</a>
                                    </td>
                                <? else: ?>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" style="color: #444444">Подробнее</a>
                                    </td>
                                <? endif; ?>
                            </tr>
                        <? endforeach; ?>
                    </table>
                </div>
            <? else: ?>
                <? if ($activeTab == 'arch'): ?>
                    <div class="table-wrap">
                        <table class="table">
                            <tr>
                                <th>Название заказа</th>
                                <th>Заказчик</th>
                                <th>Ответственный</th>
                                <th></th>
                            </tr>
                            <? foreach ($arResult['USER_ORDERS_LIST'] as $order): ?>
                                <tr>
                                    <td><?= $order['NAME'] ?></td>
                                    <td class="text-center"><?= $order['CUSTOMER']['WORK_COMPANY'] ?></td>
                                    <td><?= $order['EXECUTOR']['LAST_NAME'] ?></td>
                                    <td class="text-center">
                                        <a href="/personal/order_detail/?id=<?= $order['ID'] ?>&arch=Y">Подробнее</a>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                        </table>
                    </div>
                <? else: ?>
                    <div class="table-wrap">
                        <table class="table">
                            <tr>
                                <th>Название заказа</th>
                                <th>Заказчик</th>
                                <th>Этап</th>
                                <th>Статус</th>
                                <th>Ответственный</th>
                                <th></th>
                            </tr>
                            <? foreach ($arResult['USER_ORDERS_LIST'] as $order): ?>
                                <tr>
                                    <td><?= $order['NAME'] ?></td>
                                    <td class="text-center"><?= $order['CUSTOMER']['WORK_COMPANY'] ?></td>
                                    <td><?= $order['STEP'] ?></td>
                                    <td class="text-center"><?= $order['STATUS'] ?></td>
                                    <td><?= $order['EXECUTOR']['LAST_NAME'] ?></td>
                                    <td class="text-center">
                                        <a href="/personal/order_detail/?id=<?= $order['ID'] ?>">Подробнее</a>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                        </table>
                    </div>
                <? endif; ?>
            <? endif; ?>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", (event) => {
        let orders = new Orders(<?=CUtil::PhpToJSObject($arResult['USER'])?>);
        orders.init();
    });
</script>