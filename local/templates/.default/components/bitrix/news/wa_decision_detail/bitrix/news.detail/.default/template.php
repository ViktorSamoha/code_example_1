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
<div class="service">
    <div class="service-head">
        <? if ($arResult['DETAIL_PICTURE']['SRC']): ?>
            <img src="<?= $arResult['DETAIL_PICTURE']['SRC'] ?>" alt="<?= $arResult['DETAIL_PICTURE']['ALT'] ?>"
                 class="service-head_img">
        <? endif; ?>
        <div class="service-head_text">
            <? if ($arResult['DISPLAY_PROPERTIES']['ICON']['FILE_VALUE']): ?>
                <div class="service-head_icon">
                    <img src="<?= $arResult['DISPLAY_PROPERTIES']['ICON']['FILE_VALUE']['SRC'] ?>" alt="">
                </div>
            <? endif; ?>
            <h1 class="service-head_title"><?= $arResult['NAME'] ?></h1>
        </div>
    </div>
    <div class="service-content">
        <div class="white-block white-block--center">
            <? if ($arResult['DISPLAY_PROPERTIES']['SUBTITLE']['VALUE']): ?>
                <div class="white-block_top">
                    <b><?= $arResult['DISPLAY_PROPERTIES']['SUBTITLE']['VALUE'] ?></b>
                </div>
            <? endif; ?>
            <? if ($arResult['DISPLAY_PROPERTIES']['TOP_BLOCK_TEXT']['DISPLAY_VALUE']): ?>
                <div class="white-block_bottom">
                    <?= $arResult['DISPLAY_PROPERTIES']['TOP_BLOCK_TEXT']['DISPLAY_VALUE'] ?>
                </div>
            <? endif; ?>
        </div>
        <? if ($arResult['DISPLAY_PROPERTIES']['FOR']['VALUE']): ?>
            <div class="accent-block">
                <h3 class="s-title">Для кого потребуется:</h3>
                <div class="accent-block_description">
                    <?= $arResult['DISPLAY_PROPERTIES']['FOR']['VALUE'] ?>
                </div>
            </div>
        <? endif; ?>
        <div class="s-goals">
            <div class="s-goals_text">
                <? if ($arResult['DISPLAY_PROPERTIES']['GOALS_TITLE']['VALUE']): ?>
                    <h3 class="s-title"><?= $arResult['DISPLAY_PROPERTIES']['GOALS_TITLE']['VALUE'] ?></h3>
                <? endif; ?>
                <? if ($arResult['DISPLAY_PROPERTIES']['GOALS']['VALUE']): ?>
                    <div class="s-goals_description">
                        <? if (is_array($arResult['DISPLAY_PROPERTIES']['GOALS']['VALUE'])): ?>
                            <ul>
                                <? foreach ($arResult['DISPLAY_PROPERTIES']['GOALS']['VALUE'] as $goal): ?>
                                    <li>
                                        <?= $goal['TEXT'] ?>
                                    </li>
                                <? endforeach; ?>
                            </ul>
                        <? endif; ?>
                    </div>
                <? endif; ?>
            </div>
            <? if ($arResult['DISPLAY_PROPERTIES']['GOALS_IMG']['FILE_VALUE']): ?>
                <div class="s-goals_img">
                    <img src="<?= $arResult['DISPLAY_PROPERTIES']['GOALS_IMG']['FILE_VALUE']['SRC'] ?>" alt="">
                </div>
            <? endif; ?>
        </div>
    </div>
    <? if ($arResult['DISPLAY_PROPERTIES']['STEPS']['VALUE']): ?>
        <section class="s-section s-section--white">
            <div class="s-content-wrap">
                <div class="s-steps">
                    <? if ($arResult['DISPLAY_PROPERTIES']['STEPS_TITLE']['VALUE']): ?>
                        <h2 class="s-steps_title"><?= $arResult['DISPLAY_PROPERTIES']['STEPS_TITLE']['VALUE'] ?></h2>
                    <? endif; ?>
                    <? if (is_array($arResult['DISPLAY_PROPERTIES']['STEPS']['VALUE'])): ?>
                        <div class="s-steps_wrap">
                            <? foreach ($arResult['DISPLAY_PROPERTIES']['STEPS']['VALUE'] as $digit => $step): ?>
                                <div class="s-steps-item">
                                    <div class="s-steps-item_number">0<?= $digit + 1 ?></div>
                                    <div class="s-steps-item_description"><?= $step['TEXT'] ?></div>
                                </div>
                            <? endforeach; ?>
                        </div>
                    <? endif; ?>
                </div>
            </div>
        </section>
    <? endif; ?>
    <? if ($arResult['DISPLAY_PROPERTIES']['QUOTE']['VALUE']): ?>
        <section class="s-section">
            <div class="s-content-wrap">
                <div class="white-block">
                    <? if ($arResult['DISPLAY_PROPERTIES']['QUOTE_LABEL']['VALUE']): ?>
                        <div class="white-block_top">
                            <?= $arResult['DISPLAY_PROPERTIES']['QUOTE_LABEL']['VALUE'] ?>
                        </div>
                    <? endif; ?>
                    <div class="white-block_bottom">
                        <div class="quote">
                            <svg class="quote_icon" width="32" height="36" viewBox="0 0 32 36" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M31.5 0H22.5V14L18 36H22.5L31.5 14V0Z" fill="#DE6396"/>
                                <path d="M31.5 0H22.5V14L18 36H22.5L31.5 14V0Z" fill="#DE6396"/>
                                <path d="M31.5 0H22.5V14L18 36H22.5L31.5 14V0Z" fill="#DE6396"/>
                                <path d="M31.5 0H22.5V14L18 36H22.5L31.5 14V0Z" fill="#DE6396"/>
                                <path d="M13.5 0H4.5V14L0 36H4.5L13.5 14V0Z" fill="#DE6396"/>
                                <path d="M13.5 0H4.5V14L0 36H4.5L13.5 14V0Z" fill="#DE6396"/>
                                <path d="M13.5 0H4.5V14L0 36H4.5L13.5 14V0Z" fill="#DE6396"/>
                                <path d="M13.5 0H4.5V14L0 36H4.5L13.5 14V0Z" fill="#DE6396"/>
                            </svg>
                            <div class="quote_text">
                                <?= $arResult['DISPLAY_PROPERTIES']['QUOTE']['DISPLAY_VALUE'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <? endif; ?>
</div>