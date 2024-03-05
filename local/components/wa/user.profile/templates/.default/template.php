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

$APPLICATION->SetTitle("Личные данные");
$user = getUserData();

$activeTab = 'all';

if ($_REQUEST['filter'] == 'Y') {
    if ($_REQUEST['active'] == 'Y') {
        $activeTab = 'active';
    } else if ($_REQUEST['arch'] == 'Y') {
        $activeTab = 'arch';
    } else if ($_REQUEST['wait'] == 'Y') {
        $activeTab = 'wait';
    } else {
        $activeTab = 'all';
    }
}

?>
<div class="tabs">
    <div class="tabs-head">
        <button class="tabs-head_btn active" type="button" data-name="tab_01">Основные данные</button>
        <button class="tabs-head_btn" type="button" data-name="tab_02">Контактные данные</button>
        <button class="tabs-head_btn" type="button" data-name="tab_04">Данные учетной записи</button>
    </div>
    <div class="tabs-content">
        <div class="tabs-content_item active" data-name="tab_01">
            <div class="table-wrap">
                <table class="table">
                    <tr>
                        <td>ФИО</td>
                        <td class="text-center"><?= $arResult['USER']['NAME'] ?></td>
                        <td class="text-center">
                            <button class="btn-edit js-open-modal" type="button" data-name="modal-edit"
                                    data-type="name">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                            d="M0.5 17.0002V14.7315H15.5V17.0002H0.5ZM2.0375 12.744V10.2502L9.03125 3.25648L11.525 5.75023L4.53125 12.744H2.0375ZM12.35 4.92523L9.85625 2.43148L11.4313 0.856476C11.5688 0.693976 11.725 0.609601 11.9 0.603351C12.075 0.597101 12.25 0.681476 12.425 0.856476L13.8875 2.31898C14.05 2.48148 14.1312 2.65335 14.1312 2.8346C14.1312 3.01585 14.0625 3.18773 13.925 3.35023L12.35 4.92523Z"
                                            fill="#DE6396"/>
                                </svg>
                                <span>Редактировать</span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Компания</td>
                        <td class="text-center"><?= $arResult['USER']['WORK_COMPANY'] ?></td>
                        <td class="text-center">
                            <button class="btn-edit js-open-modal" type="button" data-name="modal-edit"
                                    data-type="company">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                            d="M0.5 17.0002V14.7315H15.5V17.0002H0.5ZM2.0375 12.744V10.2502L9.03125 3.25648L11.525 5.75023L4.53125 12.744H2.0375ZM12.35 4.92523L9.85625 2.43148L11.4313 0.856476C11.5688 0.693976 11.725 0.609601 11.9 0.603351C12.075 0.597101 12.25 0.681476 12.425 0.856476L13.8875 2.31898C14.05 2.48148 14.1312 2.65335 14.1312 2.8346C14.1312 3.01585 14.0625 3.18773 13.925 3.35023L12.35 4.92523Z"
                                            fill="#DE6396"/>
                                </svg>
                                <span>Редактировать</span>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="input-photo-block">
                <span class="input-photo-block_title">Загрузите фотографию профиля</span>
                <form id="update-user-photo" enctype="multipart/form-data">
                    <div class="input-photo">
                        <input id="input-user-photo" name="PERSONAL_PHOTO" type="file" class="input-photo_input">
                        <label for="input-user-photo" class="input-photo_preview">
                            <? if (isset($user['PERSONAL_PHOTO']) && !empty($user['PERSONAL_PHOTO'])): ?>
                                <img src="<?= $user['PERSONAL_PHOTO'] ?>" alt="">
                            <? else: ?>
                                <img src="<?= ASSETS ?>images/input-file_icon.svg" alt="">
                            <? endif; ?>
                        </label>
                        <label for="input-user-photo"
                               class="input-photo_btn <?= isset($user['PERSONAL_PHOTO']) ? 'visible' : '' ?>"
                               id="change-user-photo">Изменить
                            фото</label>
                    </div>
                </form>
                <span id="user-photo-msg"></span>
            </div>
        </div>
        <div class="tabs-content_item" data-name="tab_02">
            <div class="table-wrap">
                <table class="table">
                    <tr>
                        <td>Телефон</td>
                        <td class="text-center"><?= $arResult['USER']['PERSONAL_PHONE'] ?></td>
                        <td class="text-center">
                            <button class="btn-edit js-open-modal" type="button" data-name="modal-edit"
                                    data-type="phone">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                            d="M0.5 17.0002V14.7315H15.5V17.0002H0.5ZM2.0375 12.744V10.2502L9.03125 3.25648L11.525 5.75023L4.53125 12.744H2.0375ZM12.35 4.92523L9.85625 2.43148L11.4313 0.856476C11.5688 0.693976 11.725 0.609601 11.9 0.603351C12.075 0.597101 12.25 0.681476 12.425 0.856476L13.8875 2.31898C14.05 2.48148 14.1312 2.65335 14.1312 2.8346C14.1312 3.01585 14.0625 3.18773 13.925 3.35023L12.35 4.92523Z"
                                            fill="#DE6396"/>
                                </svg>
                                <span>Редактировать</span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td class="text-center"><?= $arResult['USER']['EMAIL'] ?></td>
                        <td class="text-center">
                            <button class="btn-edit js-open-modal" type="button" data-name="modal-edit"
                                    data-type="email">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                            d="M0.5 17.0002V14.7315H15.5V17.0002H0.5ZM2.0375 12.744V10.2502L9.03125 3.25648L11.525 5.75023L4.53125 12.744H2.0375ZM12.35 4.92523L9.85625 2.43148L11.4313 0.856476C11.5688 0.693976 11.725 0.609601 11.9 0.603351C12.075 0.597101 12.25 0.681476 12.425 0.856476L13.8875 2.31898C14.05 2.48148 14.1312 2.65335 14.1312 2.8346C14.1312 3.01585 14.0625 3.18773 13.925 3.35023L12.35 4.92523Z"
                                            fill="#DE6396"/>
                                </svg>
                                <span>Редактировать</span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Telegram</td>
                        <td class="text-center"><?= $arResult['USER']['UF_TELEGRAM_LINK'] ?></td>
                        <td class="text-center">
                            <button class="btn-edit js-open-modal" type="button" data-name="modal-edit"
                                    data-type="telegram">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                            d="M0.5 17.0002V14.7315H15.5V17.0002H0.5ZM2.0375 12.744V10.2502L9.03125 3.25648L11.525 5.75023L4.53125 12.744H2.0375ZM12.35 4.92523L9.85625 2.43148L11.4313 0.856476C11.5688 0.693976 11.725 0.609601 11.9 0.603351C12.075 0.597101 12.25 0.681476 12.425 0.856476L13.8875 2.31898C14.05 2.48148 14.1312 2.65335 14.1312 2.8346C14.1312 3.01585 14.0625 3.18773 13.925 3.35023L12.35 4.92523Z"
                                            fill="#DE6396"/>
                                </svg>
                                <span>Редактировать</span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>WhatsApp</td>
                        <td class="text-center"><?= $arResult['USER']['UF_WHATSAPP_LINK'] ?></td>
                        <td class="text-center">
                            <button class="btn-edit js-open-modal" type="button" data-name="modal-edit"
                                    data-type="whatsapp">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                            d="M0.5 17.0002V14.7315H15.5V17.0002H0.5ZM2.0375 12.744V10.2502L9.03125 3.25648L11.525 5.75023L4.53125 12.744H2.0375ZM12.35 4.92523L9.85625 2.43148L11.4313 0.856476C11.5688 0.693976 11.725 0.609601 11.9 0.603351C12.075 0.597101 12.25 0.681476 12.425 0.856476L13.8875 2.31898C14.05 2.48148 14.1312 2.65335 14.1312 2.8346C14.1312 3.01585 14.0625 3.18773 13.925 3.35023L12.35 4.92523Z"
                                            fill="#DE6396"/>
                                </svg>
                                <span>Редактировать</span>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="tabs-content_item" data-name="tab_04">
            <div class="table-wrap">
                <table class="table table--color-reverse">
                    <tr>
                        <td>Изменить свой пароль для входа</td>
                        <td class="text-center">
                            <button class="btn-edit js-open-modal" data-name="modal-edit"
                                    data-type="passwd">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                            d="M0.5 17.0002V14.7315H15.5V17.0002H0.5ZM2.0375 12.744V10.2502L9.03125 3.25648L11.525 5.75023L4.53125 12.744H2.0375ZM12.35 4.92523L9.85625 2.43148L11.4313 0.856476C11.5688 0.693976 11.725 0.609601 11.9 0.603351C12.075 0.597101 12.25 0.681476 12.425 0.856476L13.8875 2.31898C14.05 2.48148 14.1312 2.65335 14.1312 2.8346C14.1312 3.01585 14.0625 3.18773 13.925 3.35023L12.35 4.92523Z"
                                            fill="#DE6396"/>
                                </svg>
                                <span>Редактировать</span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>Удалить учетную запись</td>
                        <td class="text-center">
                            <button class="btn-remove js-open-modal" data-name="modal-remove" type="button">
                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                            d="M0.000186654 2.40775L1.75037 0.65756L14.0017 12.9089L12.2515 14.6591L0.000186654 2.40775Z"
                                            fill="#DE6396"/>
                                    <path d="M1.75019 14.6577L0 12.9076L12.2513 0.65625L14.0015 2.40644L1.75019 14.6577Z"
                                          fill="#DE6396"/>
                                </svg>
                                <span>Удалить</span>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", (event) => {
        let user = new User(<?=CUtil::PhpToJSObject($arResult['USER'])?>);
        user.init();
    });
</script>