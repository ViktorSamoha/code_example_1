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

$isPartner = false;
if ($arParams['ADD_TITLE']) {
    if (isset($arParams['IS_PARTNER'])) {
        if ($arParams['IS_PARTNER']) {
            $isPartner = true;
            $APPLICATION->SetTitle("Регистрация контрагентов");
        }
    } else {
        $APPLICATION->SetTitle("Регистрация сотрудника");
    }
}
if (isset($arParams['IS_PARTNER'])) {
    if ($arParams['IS_PARTNER']) {
        $isPartner = true;
    }
}
$formId = $arParams['FORM_ID'];
$formBtnId = $arParams['FORM_BTN_ID'];
$JS_DATA = [
    'FORM_ID' => $arParams['FORM_ID'],
    'FORM_BTN_ID' => $arParams['FORM_BTN_ID']
];
$manager = getUserData();
?>
<form action="" class="form-registration-user" id="<?= $formId ?>">
    <div class="form-item">
        <label for="NAME" class="label">ФИО сотрудника</label>
        <input type="text" class="input" name="NAME">
    </div>
    <? if ($isPartner): ?>
        <div class="form-item">
            <label for="WORK_COMPANY" class="label">Компания</label>
            <input type="text" class="input" name="WORK_COMPANY">
        </div>
    <? endif; ?>
    <? if ($manager['IS_ADMIN']): ?>
        <div class="form-item-group">
            <div class="form-item form-item--md">
                <label for="" class="label">Должность</label>
                <div class="custom-select">
                    <div class="custom-select_head">
                        <span class="custom-select_title">Выберите должность сотрудника</span>
                        <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L8 8L15 1" stroke="black"/>
                        </svg>
                    </div>
                    <div class="custom-select_body">
                        <? foreach ($arResult['USER_POST_LIST'] as $postId => $postProps): ?>
                            <div class="custom-select_item" data-id="<?= $postId ?>"><?= $postProps['NAME'] ?></div>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="form-item form-item--md">
                <button class="btn-create-item js-open-modal" data-name="modal-add-user-post">
                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M13.668 6.86914V8.41406H0.0234375V6.86914H13.668ZM7.61133 0.511719V15.0039H5.9707V0.511719H7.61133Z"
                                fill="#DE6396"/>
                    </svg>
                    <span>Добавить должность</span>
                </button>
            </div>
        </div>
    <? else: ?>
        <div class="form-item">
            <label for="" class="label">Должность</label>
            <div class="custom-select">
                <div class="custom-select_head">
                    <span class="custom-select_title">Выберите должность сотрудника</span>
                    <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L8 8L15 1" stroke="black"/>
                    </svg>
                </div>
                <div class="custom-select_body">
                    <? foreach ($arResult['USER_POST_LIST'] as $postId => $postProps): ?>
                        <div class="custom-select_item" data-id="<?= $postId ?>"><?= $postProps['NAME'] ?></div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    <? endif; ?>
    <div class="form-item">
        <label for="PERSONAL_PHONE" class="label">Телефон</label>
        <input type="tel" class="input" name="PERSONAL_PHONE">
    </div>
    <div class="form-item">
        <label for="EMAIL" class="label">E-mail</label>
        <input type="email" class="input" name="EMAIL">
    </div>
    <button class="btn-secondary" id="<?= $formBtnId ?>">Создать учетную запись</button>
</form>
<div id="form-error-msg"></div>
<script>
    window.addEventListener("load", (event) => {
        let manager = new User(<?=CUtil::PhpToJSObject($JS_DATA)?>);
        manager.init();
    });
</script>