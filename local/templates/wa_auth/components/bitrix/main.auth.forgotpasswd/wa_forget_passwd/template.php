<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

\Bitrix\Main\Page\Asset::getInstance()->addCss(
    '/bitrix/css/main/system.auth/flat/style.css'
);

if ($arResult['AUTHORIZED']) {
    echo Loc::getMessage('MAIN_AUTH_PWD_SUCCESS');
    return;
}
?>

<div class="bx-authform login">

    <? if ($arResult['ERRORS']): ?>
        <div class="alert alert-danger">
            <? foreach ($arResult['ERRORS'] as $error) {
                echo $error;
            }
            ?>
        </div>
    <? elseif ($arResult['SUCCESS']): ?>
        <div class="alert alert-success">
            <?= $arResult['SUCCESS']; ?>
        </div>
    <? endif; ?>
    <h2 class="login_title"><?= Loc::getMessage('MAIN_AUTH_PWD_HEADER'); ?></h2>

    <form name="bform" class="login-form" method="post" target="_top" action="<?= POST_FORM_ACTION_URI; ?>">

        <div class="login-item">
            <label for="" class="login-item_label">E-mail</label>
            <input type="email" name="<?= $arResult['FIELDS']['email']; ?>" class="login-item_input">
        </div>

        <? if ($arResult['CAPTCHA_CODE']): ?>
            <input type="hidden" name="captcha_sid" value="<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']); ?>"/>
            <div class="bx-authform-formgroup-container dbg_captha login-item">
                <div class="bx-authform-label-container">
                    <?= Loc::getMessage('MAIN_AUTH_PWD_FIELD_CAPTCHA'); ?>
                </div>
                <div class="bx-captcha"><img
                            src="/bitrix/tools/captcha.php?captcha_sid=<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']); ?>"
                            width="180" height="40" alt="CAPTCHA"/></div>
                <div class="bx-authform-input-container">
                    <input type="text" class="login-item_input" name="captcha_word" maxlength="50" value=""
                           autocomplete="off"/>
                </div>
            </div>
        <? endif; ?>
        <input type="submit" class="btn-primary" name="<?= $arResult['FIELDS']['action']; ?>"
               value="<?= Loc::getMessage('MAIN_AUTH_PWD_FIELD_SUBMIT'); ?>"/>
        <div class="login-form_text">
            <a href="<?= $arResult['AUTH_AUTH_URL']; ?>" class="login-form_text-item">Войти</a>
            <div class="login-form_text-item">Еще не зарегистрированы?
                <a href="<?= $arResult['AUTH_REGISTER_URL']; ?>">Регистрация</a>
            </div>
        </div>

    </form>
</div>

<script type="text/javascript">
    document.bform.<?= $arResult['FIELDS']['login'];?>.focus();
</script>
