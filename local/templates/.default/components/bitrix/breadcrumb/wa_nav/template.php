<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if (empty($arResult))
    return "";

$strReturn = '';

$strReturn .= '<nav class="i-nav">
            <a href="/" class="i-nav_home">
                <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.332031 15.5V5.5L6.9987 0.5L13.6654 5.5V15.5H8.66536V9.66667H5.33203V15.5H0.332031Z" fill="#DE6396"/>
                </svg>
            </a>';

$itemSize = count($arResult);
for ($index = 0; $index < $itemSize; $index++) {
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
    if ($arResult[$index]["LINK"] <> "" && $index != $itemSize - 1) {
        $strReturn .= '<a href="' . $arResult[$index]["LINK"] . '" class="i-nav_item">' . $title . '</a>';
    } else {
        $strReturn .= '<span class="i-nav_item">' . $title . '</span>';
    }
}

$strReturn .= '</nav>';

return $strReturn;
