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
<a name="contacts"></a>
<div class="content-wrap">
    <div class="contacts">
        <div class="contacts_text">
            <h2 class="title"><?= $arResult['NAME'] ?></h2>
            <div class="contacts_block">
                <? if (isset($arResult['DISPLAY_PROPERTIES']['ORG_NAME']) && !empty($arResult['DISPLAY_PROPERTIES']['ORG_NAME'])): ?>
                    <span><?= $arResult['DISPLAY_PROPERTIES']['ORG_NAME']['DISPLAY_VALUE'] ?>
                <? endif; ?>
                <? if (isset($arResult['DISPLAY_PROPERTIES']['ORG_ADDRESS']) && !empty($arResult['DISPLAY_PROPERTIES']['ORG_ADDRESS'])): ?>
                    <?= $arResult['DISPLAY_PROPERTIES']['ORG_ADDRESS']['DISPLAY_VALUE'] ?></span>
                <?else:?>
                    </span>
                <? endif; ?>
                <? if (isset($arResult['DISPLAY_PROPERTIES']['ORG_PHONE']) && !empty($arResult['DISPLAY_PROPERTIES']['ORG_PHONE'])): ?>
                    <a href="tel:<?= $arResult['DISPLAY_PROPERTIES']['ORG_PHONE']['DISPLAY_VALUE'] ?>"><?= $arResult['DISPLAY_PROPERTIES']['ORG_PHONE']['DISPLAY_VALUE'] ?></a>
                <? endif; ?>
                <? if (isset($arResult['DISPLAY_PROPERTIES']['ORG_EMAIL']) && !empty($arResult['DISPLAY_PROPERTIES']['ORG_EMAIL'])): ?>
                    <a href="mailto:<?= $arResult['DISPLAY_PROPERTIES']['ORG_EMAIL']['DISPLAY_VALUE'] ?>"><?= $arResult['DISPLAY_PROPERTIES']['ORG_EMAIL']['DISPLAY_VALUE'] ?></a>
                <? endif; ?>
            </div>
        </div>
        <div class="contacts_img">
            <div id="map" style="width: 824px; height: 487px"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    ymaps.ready(init);

    function init() {
        var myMap = new ymaps.Map("map", {
            center: [59.883866, 30.339353],
            zoom: 14
        });
        <?if(isset($arResult['DISPLAY_PROPERTIES']['NORTHERN_LATITUDE']) && isset($arResult['DISPLAY_PROPERTIES']['EASTERN_LONGITUDE'])):?>
        var myGeoObject = new ymaps.GeoObject({
            geometry: {
                type: "Point",
                coordinates: [<?= (float)$arResult['DISPLAY_PROPERTIES']['NORTHERN_LATITUDE']['DISPLAY_VALUE'] ?>, <?= (float)$arResult['DISPLAY_PROPERTIES']['EASTERN_LONGITUDE']['DISPLAY_VALUE'] ?>]
            }
        });
        myMap.geoObjects.add(myGeoObject);
        <?endif;?>
    }
</script>