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
<section class="section">
    <div class="screen">
        <div class="content-wrap">
            <? if (isset($arResult['AR_NAME'])): ?>
                <h2 class="title">
                    <? foreach ($arResult['AR_NAME'] as $name_part): ?>
                        <div class="animated-letters"><?= $name_part ?></div>
                    <? endforeach; ?>
                </h2>
            <? else: ?>
                <h2 class="title">
                    <div class="animated-letters"><?= $arResult['NAME'] ?></div>
                </h2>
            <? endif; ?>
            <? if (!empty($arResult['DISPLAY_PROPERTIES']['SUBTITLE']['DISPLAY_VALUE'])): ?>
                <div class="description"><?= $arResult['DISPLAY_PROPERTIES']['SUBTITLE']['DISPLAY_VALUE'] ?></div>
            <? endif; ?>
            <div class="block-w-img">
                <? if (!empty($arResult['FIELDS']['PREVIEW_PICTURE'])): ?>
                    <div class="block-w-img_img">
                        <img src="<?= $arResult['FIELDS']['PREVIEW_PICTURE']['SRC'] ?>"
                             alt="<?= $arResult['FIELDS']['PREVIEW_PICTURE']['ALT'] ?>">
                    </div>
                <? endif; ?>
                <div class="block-w-img_text">
                    <ul class="pluses">
                        <li><a href="/auth/registration.php?register=yes">Регистрируйтесь в личном кабинете</a></li>
                        <li><a href="javascript:void(0);" class="js-open-modal" data-name="modal-feedback">Пишите запрос на почту</a></li>
                        <li><a href="tel:+78124488467">Звоните нам</a></li>
                    </ul>
                   <!-- <?/* if (!empty($arResult['DISPLAY_PROPERTIES']['ACTIONS_LIST']['DISPLAY_VALUE'])): */?>
                        <ul class="pluses">
                            <?/* foreach ($arResult['DISPLAY_PROPERTIES']['ACTIONS_LIST']['DISPLAY_VALUE'] as $list_value): */?>
                                <li><?/*= $list_value */?></li>
                            <?/* endforeach; */?>
                        </ul>
                    --><?/* endif; */?>
                    <? if (!empty($arResult['FIELDS']['PREVIEW_TEXT'])): ?>
                        <div class="description">
                            <?= $arResult['FIELDS']['PREVIEW_TEXT'] ?>
                        </div>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>