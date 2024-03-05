<?php

use Bitrix\Main\Page\Asset;
use \Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
</main>

<?
global $APPLICATION;
$dir = $APPLICATION->GetCurDir();
if ($dir == "/service/ekologicheskaya-otchetnost/") {
    $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => "/includes/index/modal_feedback.php"
        )
    );
}
?>

<? if (!defined("ERROR_404")): ?>
    <footer class="i-footer">
        <a href="/" class="f-logo">
            <img src="<?= ASSETS ?>images/f-logo.png" alt="">
        </a>
        <div class="f-block">
            <a href="/auth/" class="btn-primary btn-primary--md">Начать работу</a>
            <div class="f-links">
                <a href="#" class="f-link">Политика конфиденциальности</a>
                <span class="f-links_separator">/</span>
                <a href="#" class="f-link">Пользовательское соглашение</a>
            </div>
        </div>
        <a href="" class="dev" target="_blank">
            <img src="<?= ASSETS ?>images/wa-logo.svg" alt="">
        </a>
    </footer>
<? endif; ?>
<?
Asset::getInstance()->addJs(ASSETS . 'js/lib/jquery.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/gsap.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/ScrollTrigger.min.js3');
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