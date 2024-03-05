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

$APPLICATION->SetTitle("Личные данные");
?>
<h3 class="h3">Вы можете управлять e-mail и SMS рассылками нашего сайта для получения следующих новостей:</h3>
<div class="table-wrap">
    <table class="table table--color-reverse" id="mailing-checkbox-table">
        <? if (isset($arResult['USER_MAILING_LIST']) && !empty($arResult['USER_MAILING_LIST'])): ?>
            <? foreach ($arResult['USER_MAILING_LIST'] as $propId => $propValues): ?>
                <tr>
                    <td>
                        <div class="checkbox">
                            <input type="checkbox" name="<?= $propId ?>"
                                   id="mailing-prop-<?= $propId ?>-checkbox" <?= $propValues['CHECKED'] ? 'checked' : '' ?>>
                            <label for="mailing-prop-<?= $propId ?>-checkbox">
                                <div class="checkbox_text"><?= $propValues['NAME'] ?></div>
                            </label>
                        </div>
                    </td>
                </tr>
            <? endforeach; ?>
        <? endif; ?>
        <tr>
            <td>
                <button class="btn-secondary" id="save-changes">Сохранить изменения</button>
            </td>
        </tr>
    </table>
</div>
<script>
    window.addEventListener("load", (event) => {
        let user = new User(<?=CUtil::PhpToJSObject($arResult['USER']) ?>);
        user.init();
    });
</script>