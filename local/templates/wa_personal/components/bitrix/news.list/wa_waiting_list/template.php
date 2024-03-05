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
?>
<? if (isset($arResult['ITEMS']) && !empty($arResult['ITEMS'])): ?>
    <div class="table-wrap">
        <table class="table table--color-reverse">
            <tr>
                <th>Вид услуги</th>
                <th>Заказчик</th>
                <th>Контактное лицо</th>
                <th></th>
            </tr>
            <? foreach ($arResult['ITEMS'] as $item): ?>
                <tr>
                    <td class="text-center"><?= $item['SERVICE_TYPE_NAME'] ?></td>
                    <td><?= $item['CUSTOMER_NAME'] ?></td>
                    <td class="text-center"><?= $item['CONTACT_PERSON']['NAME'] . ' ' . $item['CONTACT_PERSON']['SECOND_NAME'] ?></td>
                    <td class="text-center">
                        <a href="/personal/create_order/?id=<?= $item['DISPLAY_PROPERTIES']['CONTACT_PERSON_ID']['VALUE'] ?>&service=<?= $item['DISPLAY_PROPERTIES']['SERVICE_TYPE']['VALUE'] ?>&req=<?= $item['ID'] ?>"
                           data-item-id="<?= $item['ID'] ?>" onclick="hideElement(this)">Взять
                            в работу</a>
                    </td>
                </tr>
            <? endforeach; ?>
        </table>
    </div>
<? else: ?>
    <p>Список заявок пуст</p>
<? endif; ?>