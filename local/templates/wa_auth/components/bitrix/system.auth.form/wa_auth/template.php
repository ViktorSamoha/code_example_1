<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CJSCore::Init();
?>
<a href="/" class="login-close-btn">
    <svg width="75" height="75" viewBox="0 0 75 75" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
                d="M24.4202 24.4202L50.5781 50.5781M50.5781 24.4202L24.4202 50.5781M73 37.5C73 57.1061 57.1061 73 37.5 73C17.8939 73 2 57.1061 2 37.5C2 17.8939 17.8939 2 37.5 2C57.1061 2 73 17.8939 73 37.5Z"
                stroke="white" stroke-width="3" />
    </svg>
</a>
<div class="bx-system-auth-form login">
    <h2 class="login_title">Войти в личный кабинет</h2>
    <?
    if ($arResult['SHOW_ERRORS'] === 'Y' && $arResult['ERROR'] && !empty($arResult['ERROR_MESSAGE'])) {
        ShowMessage($arResult['ERROR_MESSAGE']);
    }
    ?>
    <? if ($arResult["FORM_TYPE"] == "login"): ?>
        <form name="system_auth_form<?= $arResult["RND"] ?>" method="post" target="_top"
              action="<?= $arResult["AUTH_URL"] ?>" class="login-form">
            <? if ($arResult["BACKURL"] <> ''): ?>
                <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
            <? endif ?>
            <? foreach ($arResult["POST"] as $key => $value): ?>
                <input type="hidden" name="<?= $key ?>" value="<?= $value ?>"/>
            <? endforeach ?>
            <input type="hidden" name="AUTH_FORM" value="Y"/>
            <input type="hidden" name="TYPE" value="AUTH"/>
            <div class="login-item">
                <label for="USER_LOGIN" class="login-item_label">E-mail</label>
                <input type="text" class="login-item_input" name="USER_LOGIN" maxlength="50" value="" size="17"/>
                <script>
                    BX.ready(function () {
                        var loginCookie = BX.getCookie("<?=CUtil::JSEscape($arResult["~LOGIN_COOKIE_NAME"])?>");
                        if (loginCookie) {
                            var form = document.forms["system_auth_form<?=$arResult["RND"]?>"];
                            var loginInput = form.elements["USER_LOGIN"];
                            loginInput.value = loginCookie;
                        }
                    });
                </script>
            </div>
            <div class="login-item">
                <label for="USER_PASSWORD" class="login-item_label">Пароль</label>
                <input type="password" class="login-item_input" name="USER_PASSWORD" maxlength="255" size="17"
                       autocomplete="off"/>
                <? if ($arResult["SECURE_AUTH"]): ?>
                    <span class="bx-auth-secure" id="bx_auth_secure<?= $arResult["RND"] ?>"
                          title="<? echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
                    <noscript>
				<span class="bx-auth-secure" title="<? echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
                    </noscript>
                    <script type="text/javascript">
                        document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
                    </script>
                <? endif ?>
            </div>
            <? if ($arResult["CAPTCHA_CODE"]): ?>
                <div class="login-item">
                    <label for="" class="login-item_label">Введите код с картинки</label>
                    <input type="hidden" name="captcha_sid" value="<? echo $arResult["CAPTCHA_CODE"] ?>"/>
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<? echo $arResult["CAPTCHA_CODE"] ?>"
                         width="180" height="40" alt="CAPTCHA"/><br/><br/>
                    <input type="text" class="login-item_input" name="captcha_word" maxlength="50" value=""/>
                </div>
            <? endif ?>
            <input type="submit" name="Login" class="btn-primary" value="Войти"/>
            <div class="login-form_text">
                <a href="<?= $arResult["AUTH_FORGOT_PASSWORD_URL"] ?>" class="login-form_text-item">Забыли пароль?</a>
                <div class="login-form_text-item">Еще не зарегистрированы?
                    <a href="<?= $arResult["AUTH_REGISTER_URL"] ?>">Регистрация</a>
                </div>
            </div>
        </form>
    <?
    elseif ($arResult["FORM_TYPE"] == "otp"):
        ?>
        <form name="system_auth_form<?= $arResult["RND"] ?>" method="post" target="_top"
              action="<?= $arResult["AUTH_URL"] ?>">
            <? if ($arResult["BACKURL"] <> ''): ?>
                <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
            <? endif ?>
            <input type="hidden" name="AUTH_FORM" value="Y"/>
            <input type="hidden" name="TYPE" value="OTP"/>
            <table width="95%">
                <tr>
                    <td colspan="2">
                        <? echo GetMessage("auth_form_comp_otp") ?><br/>
                        <input type="text" name="USER_OTP" maxlength="50" value="" size="17" autocomplete="off"/></td>
                </tr>
                <? if ($arResult["CAPTCHA_CODE"]): ?>
                    <tr>
                        <td colspan="2">
                            <? echo GetMessage("AUTH_CAPTCHA_PROMT") ?>:<br/>
                            <input type="hidden" name="captcha_sid" value="<? echo $arResult["CAPTCHA_CODE"] ?>"/>
                            <img src="/bitrix/tools/captcha.php?captcha_sid=<? echo $arResult["CAPTCHA_CODE"] ?>"
                                 width="180" height="40" alt="CAPTCHA"/><br/><br/>
                            <input type="text" name="captcha_word" maxlength="50" value=""/></td>
                    </tr>
                <? endif ?>
                <? if ($arResult["REMEMBER_OTP"] == "Y"): ?>
                    <tr>
                        <td valign="top"><input type="checkbox" id="OTP_REMEMBER_frm" name="OTP_REMEMBER" value="Y"/>
                        </td>
                        <td width="100%"><label for="OTP_REMEMBER_frm"
                                                title="<? echo GetMessage("auth_form_comp_otp_remember_title") ?>"><? echo GetMessage("auth_form_comp_otp_remember") ?></label>
                        </td>
                    </tr>
                <? endif ?>
                <tr>
                    <td colspan="2"><input type="submit" name="Login" value="<?= GetMessage("AUTH_LOGIN_BUTTON") ?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <noindex><a href="<?= $arResult["AUTH_LOGIN_URL"] ?>"
                                    rel="nofollow"><? echo GetMessage("auth_form_comp_auth") ?></a></noindex>
                        <br/></td>
                </tr>
            </table>
        </form>
    <?
    else:
        ?>
        <?
        LocalRedirect("/personal/");
        ?>
    <? endif ?>
</div>
