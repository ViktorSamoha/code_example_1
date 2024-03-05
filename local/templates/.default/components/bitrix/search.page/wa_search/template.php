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
?>

    <h1 class="inner-title">Поиск</h1>

    <form class="i-search-form" method="get">
        <label for="" class="i-search-form_label">Введите ваш запрос</label>
        <div class="i-search-form_wrap">
            <? if ($arParams["USE_SUGGEST"] === "Y"):
                if (mb_strlen($arResult["REQUEST"]["~QUERY"]) && is_object($arResult["NAV_RESULT"])) {
                    $arResult["FILTER_MD5"] = $arResult["NAV_RESULT"]->GetFilterMD5();
                    $obSearchSuggest = new CSearchSuggest($arResult["FILTER_MD5"], $arResult["REQUEST"]["~QUERY"]);
                    $obSearchSuggest->SetResultCount($arResult["NAV_RESULT"]->NavRecordCount);
                }
                ?>
                <? $APPLICATION->IncludeComponent(
                "bitrix:search.suggest.input",
                "",
                array(
                    "NAME" => "q",
                    "VALUE" => $arResult["REQUEST"]["~QUERY"],
                    "INPUT_SIZE" => 40,
                    "DROPDOWN_SIZE" => 10,
                    "FILTER_MD5" => $arResult["FILTER_MD5"],
                ),
                $component, array("HIDE_ICONS" => "Y")
            ); ?>
            <? else: ?>
                <input class="i-search-form_input" type="text" name="q" value="<?= $arResult["REQUEST"]["QUERY"] ?>"
                       size="40"/>
            <? endif; ?>
            <? if ($arParams["SHOW_WHERE"]): ?>
                &nbsp;<select name="where">
                    <option value=""><?= GetMessage("SEARCH_ALL") ?></option>
                    <? foreach ($arResult["DROPDOWN"] as $key => $value): ?>
                        <option value="<?= $key ?>"<? if ($arResult["REQUEST"]["WHERE"] == $key) echo " selected" ?>><?= $value ?></option>
                    <? endforeach ?>
                </select>
            <? endif; ?>
            &nbsp;<input type="submit" class="i-search-form_btn btn-primary" value="<?= GetMessage("SEARCH_GO") ?>"/>
            <input type="hidden" name="how" value="<? echo $arResult["REQUEST"]["HOW"] == "d" ? "d" : "r" ?>"/>
        </div>
    </form>
<? if (isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
    ?>
    <div class="search-language-guess">
        <? echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#" => '<a href="' . $arResult["ORIGINAL_QUERY_URL"] . '">' . $arResult["REQUEST"]["ORIGINAL_QUERY"] . '</a>')) ?>
    </div><br/><?
endif; ?>
<? if ($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false): ?>
<? elseif ($arResult["ERROR_CODE"] != 0): ?>
    <p><?= GetMessage("SEARCH_ERROR") ?></p>
    <? ShowError($arResult["ERROR_TEXT"]); ?>
    <p><?= GetMessage("SEARCH_CORRECT_AND_CONTINUE") ?></p>
    <br/><br/>
    <p><?= GetMessage("SEARCH_SINTAX") ?><br/><b><?= GetMessage("SEARCH_LOGIC") ?></b></p>
    <table border="0" cellpadding="5">
        <tr>
            <td align="center" valign="top"><?= GetMessage("SEARCH_OPERATOR") ?></td>
            <td valign="top"><?= GetMessage("SEARCH_SYNONIM") ?></td>
            <td><?= GetMessage("SEARCH_DESCRIPTION") ?></td>
        </tr>
        <tr>
            <td align="center" valign="top"><?= GetMessage("SEARCH_AND") ?></td>
            <td valign="top">and, &amp;, +</td>
            <td><?= GetMessage("SEARCH_AND_ALT") ?></td>
        </tr>
        <tr>
            <td align="center" valign="top"><?= GetMessage("SEARCH_OR") ?></td>
            <td valign="top">or, |</td>
            <td><?= GetMessage("SEARCH_OR_ALT") ?></td>
        </tr>
        <tr>
            <td align="center" valign="top"><?= GetMessage("SEARCH_NOT") ?></td>
            <td valign="top">not, ~</td>
            <td><?= GetMessage("SEARCH_NOT_ALT") ?></td>
        </tr>
        <tr>
            <td align="center" valign="top">( )</td>
            <td valign="top">&nbsp;</td>
            <td><?= GetMessage("SEARCH_BRACKETS_ALT") ?></td>
        </tr>
    </table>
<? elseif (count($arResult["SEARCH"]) > 0): ?>
    <div class="search-result">
        <h3 class="search-result_title">Найдено по вашему запросу:</h3>
        <div class="search-result_list">
            <? foreach ($arResult["SEARCH"] as $arItem): ?>
                <div class="sr-item">
                    <div class="sr-item_title">
                        <a href="<? echo $arItem["URL"] ?>"><? echo $arItem["TITLE_FORMATED"] ?></a>
                    </div>
                    <div class="sr-item_description">
                        <? echo $arItem["BODY_FORMATED"] ?>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
    <? if ($arParams["DISPLAY_BOTTOM_PAGER"] != "N") {echo $arResult["NAV_STRING"];} ?>
<? else: ?>
    <? ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND")); ?>
<? endif; ?>