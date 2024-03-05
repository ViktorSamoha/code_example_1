<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if ($arResult["SHOW_SMS_FIELD"] == true) {
    CJSCore::Init('phone_auth');
}
?>
<a href="/" class="login-close-btn">
    <svg width="75" height="75" viewBox="0 0 75 75" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
                d="M24.4202 24.4202L50.5781 50.5781M50.5781 24.4202L24.4202 50.5781M73 37.5C73 57.1061 57.1061 73 37.5 73C17.8939 73 2 57.1061 2 37.5C2 17.8939 17.8939 2 37.5 2C57.1061 2 73 17.8939 73 37.5Z"
                stroke="white" stroke-width="3" />
    </svg>
</a>
<div class="bx-auth-reg login">

    <? if ($USER->IsAuthorized()): ?>

        <p><? echo GetMessage("MAIN_REGISTER_AUTH") ?></p>

    <? else: ?>
    <?
    if (!empty($arResult["ERRORS"])):
        foreach ($arResult["ERRORS"] as $key => $error)
            if (intval($key) == 0 && $key !== 0)
                $arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;" . GetMessage("REGISTER_FIELD_" . $key) . "&quot;", $error);

        ShowError(implode("<br />", $arResult["ERRORS"]));

    elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
    ?>
        <p><? echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT") ?></p>
    <? endif ?>

        <h2 class="login_title">Регистрация</h2>

    <? if ($arResult["SHOW_SMS_FIELD"] == true): ?>

        <form method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform">
            <?
            if ($arResult["BACKURL"] <> ''):
                ?>
                <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
            <?
            endif;
            ?>
            <input type="hidden" name="SIGNED_DATA" value="<?= htmlspecialcharsbx($arResult["SIGNED_DATA"]) ?>"/>
            <table>
                <tbody>
                <tr>
                    <td><? echo GetMessage("main_register_sms") ?><span class="starrequired">*</span></td>
                    <td><input size="30" type="text" name="SMS_CODE"
                               value="<?= htmlspecialcharsbx($arResult["SMS_CODE"]) ?>" autocomplete="off"/></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td><input type="submit" name="code_submit_button"
                               value="<? echo GetMessage("main_register_sms_send") ?>"/></td>
                </tr>
                </tfoot>
            </table>
        </form>

        <script>
            new BX.PhoneAuth({
                containerId: 'bx_register_resend',
                errorContainerId: 'bx_register_error',
                interval: <?=$arResult["PHONE_CODE_RESEND_INTERVAL"]?>,
                data:
                    <?=CUtil::PhpToJSObject([
                        'signedData' => $arResult["SIGNED_DATA"],
                    ])?>,
                onError:
                    function (response) {
                        var errorDiv = BX('bx_register_error');
                        var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
                        errorNode.innerHTML = '';
                        for (var i = 0; i < response.errors.length; i++) {
                            errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
                        }
                        errorDiv.style.display = '';
                    }
            });
        </script>

        <div id="bx_register_error" style="display:none"><? ShowError("error") ?></div>

        <div id="bx_register_resend"></div>

    <? else: ?>
        <form method="post" class="login-form" action="<?= POST_FORM_ACTION_URI ?>" name="regform"
              enctype="multipart/form-data">
            <?
            if ($arResult["BACKURL"] <> ''):
                ?>
                <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
            <?
            endif;
            ?>

            <div class="login-item">
                <label for="REGISTER[NAME]" class="login-item_label">ФИО</label>
                <input size="30" type="text" name="REGISTER[NAME]" value=""
                       class="bx-auth-input login-item_input"/>
            </div>
            <div class="login-item">
                <label for="REGISTER[WORK_COMPANY]" class="login-item_label">Компания</label>
                <input size="30" type="text" name="REGISTER[WORK_COMPANY]" value=""
                       class="bx-auth-input login-item_input"/>
            </div>
            <div class="login-item">
                <label for="REGISTER[PERSONAL_PHONE]" class="login-item_label">Телефон</label>
                <input size="30" type="text" name="REGISTER[PERSONAL_PHONE]" value=""
                       class="bx-auth-input login-item_input"/>
            </div>
            <div class="login-item">
                <label for="REGISTER[EMAIL]" class="login-item_label">E-mail</label>
                <input size="30" type="email" name="REGISTER[EMAIL]" value=""
                       class="bx-auth-input login-item_input"/>
                <input type="hidden" name="REGISTER[LOGIN]">
            </div>
            <div class="login-item">
                <label for="REGISTER[PASSWORD]" class="login-item_label">Пароль</label>
                <input size="30" type="password" name="REGISTER[PASSWORD]" value="" autocomplete="off"
                       class="bx-auth-input login-item_input"/>
                <input type="hidden" name="REGISTER[CONFIRM_PASSWORD]">
            </div>
            <? // ********************* User properties ***************************************************?>
            <? if ($arResult["USER_PROPERTIES"]["SHOW"] == "Y"): ?>
                <? foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField): ?>
                    <?
                    if ($arUserField["USER_TYPE"]["USER_TYPE_ID"] == 'enumeration') {
                        ?>
                        <div class="login-item login-item--flex">
                            <label for="" class="login-item_label">Удобный способ связи</label>
                            <div class="radio-group">
                                <div class="radio">
                                    <input type="radio" id="com-type-radio-1" name="UF_COM_TYPE" value="1" checked>
                                    <label for="com-type-radio-1">
                                        <div class="radio_text">Телефон</div>
                                    </label>
                                </div>
                                <div class="radio">
                                    <input type="radio" id="com-type-radio-2" name="UF_COM_TYPE" value="2">
                                    <label for="com-type-radio-2">
                                        <div class="radio_text">E-mail</div>
                                    </label>
                                </div>
                                <div class="radio">
                                    <input type="radio" id="com-type-radio-3" name="UF_COM_TYPE" value="3">
                                    <label for="com-type-radio-3">
                                        <div class="radio_text">WhatsApp</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?
                    } ?>
                <? endforeach; ?>
            <? endif; ?>
            <? // ******************** /User properties ***************************************************?>

            <?
            /* CAPTCHA */
            if ($arResult["USE_CAPTCHA"] == "Y") {
                ?>
                <div class="login-item">
                    <label for="captcha_word" class="login-item_label">ведите код с картинки</label>
                    <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>"
                         width="180" height="40" alt="CAPTCHA"/>
                    <input type="text" name="captcha_word" class="login-item_input" maxlength="50" value=""
                           autocomplete="off"/>
                </div>
                <?
            }
            /* !CAPTCHA */
            ?>
            <input type="submit" name="register_submit_button" class="btn-primary" value="Регистрация"/>
            <div class="login-form_text">
                <div class="login-form_text-item">Уже зарегистрированы?
                    <a href="/auth/index.php">Войти</a>
                </div>
            </div>
        </form>
    <? endif //$arResult["SHOW_SMS_FIELD"] == true ?>
    <? endif ?>
</div>