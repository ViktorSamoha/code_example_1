<?php

use \Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
</main>

<?
$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    array(
        "AREA_FILE_SHOW" => "file",
        "PATH" => "/includes/index/modal_feedback.php"
    )
);
?>

<?
Asset::getInstance()->addJs(ASSETS . 'js/lib/jquery.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/gsap.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/ScrollTrigger.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/jquery.fullpage.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/flatpickr.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/flatpickr-ru.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/rangePlugin.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/inputmask.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/app/main.js');
Asset::getInstance()->addJs('/local/templates/.default/assets/js/custom.js');
?>

</body>

</html>