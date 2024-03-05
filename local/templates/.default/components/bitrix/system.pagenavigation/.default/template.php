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

if (!$arResult["NavShowAlways"]) {
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");
?>
<nav class="page-nav">
    <? if ($arResult["bDescPageNumbering"] === true): ?>
        <div class="page-nav_left">
            <? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
                <? if ($arResult["bSavePage"]): ?>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>"
                       class="page-nav_btn">
                        <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M6.75414 9.35351L14.9982 1.10949L14.1211 0.232422L5 9.35351L14.1211 18.4746L14.9982 17.5975L6.75414 9.35351Z"
                                  fill="#DE6396"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M1.75414 9.35351L9.99816 1.10949L9.12109 0.232422L0 9.35351L9.12109 18.4746L9.99816 17.5975L1.75414 9.35351Z"
                                  fill="#DE6396"/>
                        </svg>
                    </a>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"
                       class="page-nav_btn">
                        <svg width="10" height="19" viewBox="0 0 10 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M1.75414 9.35351L9.99816 1.10949L9.12109 0.232422L0 9.35351L9.12109 18.4746L9.99816 17.5975L1.75414 9.35351Z"
                                  fill="#DE6396"/>
                        </svg>
                    </a>
                <? else: ?>
                    <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>" class="page-nav_btn">
                        <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M6.75414 9.35351L14.9982 1.10949L14.1211 0.232422L5 9.35351L14.1211 18.4746L14.9982 17.5975L6.75414 9.35351Z"
                                  fill="#DE6396"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M1.75414 9.35351L9.99816 1.10949L9.12109 0.232422L0 9.35351L9.12109 18.4746L9.99816 17.5975L1.75414 9.35351Z"
                                  fill="#DE6396"/>
                        </svg>
                    </a>
                    <? if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"] + 1)): ?>
                        <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"
                           class="page-nav_btn">
                            <svg width="10" height="19" viewBox="0 0 10 19" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M1.75414 9.35351L9.99816 1.10949L9.12109 0.232422L0 9.35351L9.12109 18.4746L9.99816 17.5975L1.75414 9.35351Z"
                                      fill="#DE6396"/>
                            </svg>
                        </a>
                    <? else: ?>
                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"
                           class="page-nav_btn">
                            <svg width="10" height="19" viewBox="0 0 10 19" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M1.75414 9.35351L9.99816 1.10949L9.12109 0.232422L0 9.35351L9.12109 18.4746L9.99816 17.5975L1.75414 9.35351Z"
                                      fill="#DE6396"/>
                            </svg>
                        </a>
                    <? endif ?>
                <? endif ?>
            <? endif ?>
            <? while ($arResult["nStartPage"] >= $arResult["nEndPage"]): ?>
                <? $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1; ?>
                <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]): ?>
                    <a href="javascript:void(0);" class="page-nav_item active"><?= $NavRecordGroupPrint ?></a>
                <? elseif ($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false): ?>
                    <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"
                       class="page-nav_item"><?= $NavRecordGroupPrint ?></a>
                <? else: ?>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"
                       class="page-nav_item"><?= $NavRecordGroupPrint ?></a>
                <? endif ?>
                <? $arResult["nStartPage"]-- ?>
            <? endwhile ?>
            <? if ($arResult["NavPageNomer"] > 1): ?>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"
                   class="page-nav_btn">
                    <svg width="10" height="19" viewBox="0 0 10 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M8.24402 9.35351L0 1.10949L0.87707 0.232422L9.99816 9.35351L0.87707 18.4746L0 17.5975L8.24402 9.35351Z"
                              fill="#DE6396"/>
                    </svg>
                </a>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1"
                   class="page-nav_btn">
                    <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M8.24402 9.35351L0 1.10949L0.87707 0.232422L9.99816 9.35351L0.87707 18.4746L0 17.5975L8.24402 9.35351Z"
                              fill="#DE6396"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M13.244 9.35351L5 1.10949L5.87707 0.232422L14.9982 9.35351L5.87707 18.4746L5 17.5975L13.244 9.35351Z"
                              fill="#DE6396"/>
                    </svg>
                </a>
            <? endif ?>
        </div>
    <? else: ?>
        <div class="page-nav_left">
            <? if ($arResult["NavPageNomer"] > 1): ?>
                <? if ($arResult["bSavePage"]): ?>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1"
                       class="page-nav_btn">
                        <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M6.75414 9.35351L14.9982 1.10949L14.1211 0.232422L5 9.35351L14.1211 18.4746L14.9982 17.5975L6.75414 9.35351Z"
                                  fill="#DE6396"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M1.75414 9.35351L9.99816 1.10949L9.12109 0.232422L0 9.35351L9.12109 18.4746L9.99816 17.5975L1.75414 9.35351Z"
                                  fill="#DE6396"/>
                        </svg>
                    </a>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"
                       class="page-nav_btn">
                        <svg width="10" height="19" viewBox="0 0 10 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M1.75414 9.35351L9.99816 1.10949L9.12109 0.232422L0 9.35351L9.12109 18.4746L9.99816 17.5975L1.75414 9.35351Z"
                                  fill="#DE6396"/>
                        </svg>
                    </a>
                <? else: ?>
                    <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"
                       class="page-nav_btn">
                        <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M6.75414 9.35351L14.9982 1.10949L14.1211 0.232422L5 9.35351L14.1211 18.4746L14.9982 17.5975L6.75414 9.35351Z"
                                  fill="#DE6396"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M1.75414 9.35351L9.99816 1.10949L9.12109 0.232422L0 9.35351L9.12109 18.4746L9.99816 17.5975L1.75414 9.35351Z"
                                  fill="#DE6396"/>
                        </svg>
                    </a>
                    <? if ($arResult["NavPageNomer"] > 2): ?>
                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"
                           class="page-nav_btn">
                            <svg width="10" height="19" viewBox="0 0 10 19" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M1.75414 9.35351L9.99816 1.10949L9.12109 0.232422L0 9.35351L9.12109 18.4746L9.99816 17.5975L1.75414 9.35351Z"
                                      fill="#DE6396"/>
                            </svg>
                        </a>
                    <? else: ?>
                        <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"
                           class="page-nav_btn">
                            <svg width="10" height="19" viewBox="0 0 10 19" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M1.75414 9.35351L9.99816 1.10949L9.12109 0.232422L0 9.35351L9.12109 18.4746L9.99816 17.5975L1.75414 9.35351Z"
                                      fill="#DE6396"/>
                            </svg>
                        </a>
                    <? endif ?>
                <? endif ?>
            <? endif ?>
            <? while ($arResult["nStartPage"] <= $arResult["nEndPage"]): ?>

                <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]): ?>
                    <a href="javascript:void(0);" class="page-nav_item active"><?= $arResult["nStartPage"] ?></a>
                <? elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false): ?>
                    <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"
                       class="page-nav_item"><?= $arResult["nStartPage"] ?></a>
                <? else: ?>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"
                       class="page-nav_item"><?= $arResult["nStartPage"] ?></a>
                <? endif ?>
                <? $arResult["nStartPage"]++ ?>
            <? endwhile ?>
            <? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]): ?>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"
                   class="page-nav_btn">
                    <svg width="10" height="19" viewBox="0 0 10 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M8.24402 9.35351L0 1.10949L0.87707 0.232422L9.99816 9.35351L0.87707 18.4746L0 17.5975L8.24402 9.35351Z"
                              fill="#DE6396"/>
                    </svg>
                </a>
                <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>"
                   class="page-nav_btn">
                    <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M8.24402 9.35351L0 1.10949L0.87707 0.232422L9.99816 9.35351L0.87707 18.4746L0 17.5975L8.24402 9.35351Z"
                              fill="#DE6396"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M13.244 9.35351L5 1.10949L5.87707 0.232422L14.9982 9.35351L5.87707 18.4746L5 17.5975L13.244 9.35351Z"
                              fill="#DE6396"/>
                    </svg>
                </a>
            <? endif ?>
        </div>
    <? endif; ?>
    <div class="page-nav_right">
        <div class="page-nav_info">Страница <?= $arResult["NavPageNomer"] ?> (<?= $arResult["NavPageCount"] ?>
            )
        </div>
        <? if ($arResult["bShowAll"]): ?>
            <noindex>
                <? if ($arResult["NavShowAll"]): ?>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>SHOWALL_<?= $arResult["NavNum"] ?>=0"
                       class="page-nav_all"><?= GetMessage("nav_paged") ?></a>
                <? else: ?>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>SHOWALL_<?= $arResult["NavNum"] ?>=1"
                       class="page-nav_all">Показать все</a>
                <? endif; ?>
            </noindex>
        <? endif; ?>
    </div>

</nav>
