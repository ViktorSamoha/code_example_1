<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
        <h1 class="inner-title"><?=$arResult['SECTION']['NAME']?></h1>
        <h3><?=$arResult['NAME']?></h3>
        <?=$arResult['DETAIL_TEXT']?>
        <div class="banner-order">
            <div class="banner-order_text">
                <?=$arResult['SECTION']['BTN_SIGNATURE']?>
            </div>
            <button class="banner-order_btn js-open-modal" type="button" data-name="modal-feedback">Заказать</button>
        </div>

    </div>
    <div class="i-catalog_img">
        <img src="<?=$arResult['SECTION']['DETAIL_PICTURE']?>" alt="">
    </div>
</section>