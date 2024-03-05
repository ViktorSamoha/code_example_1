<?php

use \Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
</main>

<div class="modal" data-name="modal-edit">
    <div class="modal_block">
        <button class="modal-close-btn js-close-modal">
            <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 2.82843L2.82843 0L32.578 29.7495L29.7495 32.578L0 2.82843Z" fill="white"/>
                <path d="M3 32.8284L0.171573 30L29.9211 0.250454L32.7495 3.07888L3 32.8284Z" fill="white"/>
            </svg>
        </button>
        <div class="modal_content">
            <h3 class="modal_title">Редактировать данные</h3>
            <form action="" class="form-edit" id="form-edit">
                <div class="form-item">
                    <label for="" class="label">ФИО</label>
                    <input type="text" class="input input--border-bottom"
                           value="Константинопольский Константин Константинович">
                </div>
                <button class="btn-primary">Сохранить изменения</button>
            </form>
        </div>
    </div>
</div>

<div class="modal" data-name="modal-remove">
    <div class="modal_block">
        <button class="modal-close-btn js-close-modal">
            <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 2.82843L2.82843 0L32.578 29.7495L29.7495 32.578L0 2.82843Z" fill="white"/>
                <path d="M3 32.8284L0.171573 30L29.9211 0.250454L32.7495 3.07888L3 32.8284Z" fill="white"/>
            </svg>
        </button>
        <div class="modal_content">
            <h3 class="modal_title">Удалить запись?</h3>
            <div class="remove-btns remove-btns--mt">
                <button class="btn-gray js-close-modal">Нет</button>
                <button class="btn-primary" id="del-user">Да</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" data-name="modal-chat">
    <div class="modal_block">
        <button class="modal-close-btn js-close-modal">
            <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 2.82843L2.82843 0L32.578 29.7495L29.7495 32.578L0 2.82843Z" fill="white"/>
                <path d="M3 32.8284L0.171573 30L29.9211 0.250454L32.7495 3.07888L3 32.8284Z" fill="white"/>
            </svg>
        </button>
        <?
        $session = \Bitrix\Main\Application::getInstance()->getSession();
        $order_id = $session['chat_order_id'];
        $manager_id = $session['chat_manager_id'];
        if ($order_id && $manager_id) {
            $APPLICATION->IncludeComponent(
                "wa:chat",
                "",
                [
                    'ORDER_ID' => $order_id,
                    'MANAGER_ID' => $manager_id,
                ],
                false
            );
        }
        ?>
    </div>
</div>

<div class="modal" data-name="modal-add-counterparty">
    <div class="modal_block">
        <button class="modal-close-btn js-close-modal">
            <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 2.82843L2.82843 0L32.578 29.7495L29.7495 32.578L0 2.82843Z" fill="white"/>
                <path d="M3 32.8284L0.171573 30L29.9211 0.250454L32.7495 3.07888L3 32.8284Z" fill="white"/>
            </svg>
        </button>
        <div class="modal_content">
            <h3 class="modal_title">Регистрация контрагента</h3>
            <?
            $APPLICATION->IncludeComponent(
                "wa:manager.profile",
                "add_user",
                [
                    'ADD_TITLE' => false,
                    'IS_PARTNER' => true,
                    'FORM_ID' => 'form-registration-counterparty',
                    'FORM_BTN_ID' => 'create-counterparty',
                ],
                false
            );
            ?>
        </div>
    </div>
</div>

<div class="modal" data-name="modal-add-type-of-work">
    <div class="modal_block">
        <button class="modal-close-btn js-close-modal">
            <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 2.82843L2.82843 0L32.578 29.7495L29.7495 32.578L0 2.82843Z" fill="white"/>
                <path d="M3 32.8284L0.171573 30L29.9211 0.250454L32.7495 3.07888L3 32.8284Z" fill="white"/>
            </svg>
        </button>
        <div class="modal_content">
            <h3 class="modal_title">Добавление вида работ</h3>
            <?
            $APPLICATION->IncludeComponent(
                "wa:manager.profile",
                "add_work_type",
                [
                    'ADD_TITLE' => false,
                ],
                false
            );
            ?>
        </div>
    </div>
</div>

<div class="modal" data-name="modal-add-user-post">
    <div class="modal_block">
        <button class="modal-close-btn js-close-modal">
            <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 2.82843L2.82843 0L32.578 29.7495L29.7495 32.578L0 2.82843Z" fill="white"/>
                <path d="M3 32.8284L0.171573 30L29.9211 0.250454L32.7495 3.07888L3 32.8284Z" fill="white"/>
            </svg>
        </button>
        <div class="modal_content">
            <h3 class="modal_title">Добавление должности</h3>
            <?
            $APPLICATION->IncludeComponent(
                "wa:manager.profile",
                "add_user_post",
                [],
                false
            );
            ?>
        </div>
    </div>
</div>

<div class="modal" data-name="modal-add-user">
    <div class="modal_block">
        <button class="modal-close-btn js-close-modal">
            <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 2.82843L2.82843 0L32.578 29.7495L29.7495 32.578L0 2.82843Z" fill="white"/>
                <path d="M3 32.8284L0.171573 30L29.9211 0.250454L32.7495 3.07888L3 32.8284Z" fill="white"/>
            </svg>
        </button>
        <div class="modal_content">
            <h3 class="modal_title">Добавление сотрудника</h3>
            <?
            $APPLICATION->IncludeComponent(
                "wa:manager.profile",
                "add_user",
                [
                    'ADD_TITLE' => false,
                    'FORM_ID' => 'form-registration-user',
                    'FORM_BTN_ID' => 'create-user',
                ],
                false
            );
            ?>
        </div>
    </div>
</div>
<?
Asset::getInstance()->addJs(ASSETS . 'js/lib/jquery.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/gsap.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/ScrollTrigger.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/jquery.fullpage.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/flatpickr.min.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/flatpickr-ru.js');
Asset::getInstance()->addJs(ASSETS . 'js/lib/rangePlugin.js');
Asset::getInstance()->addJs(ASSETS . 'js/app/main.js');
Asset::getInstance()->addJs('/local/templates/.default/assets/js/custom.js');
?>
</body>
</html>