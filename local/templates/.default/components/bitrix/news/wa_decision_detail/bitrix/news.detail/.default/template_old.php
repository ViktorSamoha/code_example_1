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
<section class="i-catalog">
    <div class="i-catalog_text">
        <h1 class="inner-title"><?= $arResult['NAME'] ?></h1>
        <? if (isset($arResult['DISPLAY_PROPERTIES']['GOALS']['DISPLAY_VALUE']) && !empty($arResult['DISPLAY_PROPERTIES']['GOALS']['DISPLAY_VALUE'])): ?>
            <?= $arResult['DISPLAY_PROPERTIES']['GOALS']['DISPLAY_VALUE'] ?>
        <? endif; ?>
        <div class="hidden-text">
            <? if (isset($arResult['DETAIL_TEXT']) && !empty($arResult['DETAIL_TEXT'])): ?>
                <?= $arResult['DETAIL_TEXT'] ?>
            <? endif; ?>
        </div>
        <button class="show-more-btn">
            <span>Подробнее</span>
            <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L7 7L13 1" stroke="#DE6396"/>
            </svg>
        </button>
        <div class="banner-order">
            <div class="banner-order_text">
                <? if (isset($arResult['DISPLAY_PROPERTIES']['BTN_SIGNATURE']['DISPLAY_VALUE']) && !empty($arResult['DISPLAY_PROPERTIES']['BTN_SIGNATURE']['DISPLAY_VALUE'])): ?>
                    <?= $arResult['DISPLAY_PROPERTIES']['BTN_SIGNATURE']['DISPLAY_VALUE'] ?>
                <? endif; ?>
            </div>
            <button class="banner-order_btn js-open-modal" type="button" data-name="modal-feedback">Заказать</button>
        </div>
    </div>
    <? if (!empty($arResult['FIELDS']['DETAIL_PICTURE'])): ?>
        <div class="i-catalog_img">
            <img src="<?= $arResult['FIELDS']['DETAIL_PICTURE']['SRC'] ?>"
                 alt="<?= $arResult['FIELDS']['DETAIL_PICTURE']['ALT'] ?>">
        </div>
    <? endif; ?>
</section>