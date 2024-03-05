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
$user = getUserData();
$currentUserId = $user['ID'];
$JS_DATA = [
    'USER' => $user,
    'ORDER_ID' => $arParams['ORDER_ID'],
    'MANAGER_ID' => $arParams['MANAGER_ID'],
];
?>
<div class="chat">
    <div class="chat_body">
        <div class="chat_messages">
            <? foreach ($arResult['CHAT_STRUCTURE'] as $message): ?>
                <? if ($message['SENDER']['ID'] == $currentUserId): ?>
                    <div class="chat-message message-self">
                        <div class="chat-message-box">
                            <?= $message['TEXT'] ?>
                        </div>
                    </div>
                <? else: ?>
                    <div class="chat-message chat-message--dark">
                        <div class="chat-message-box">
                            <?= $message['TEXT'] ?>
                        </div>
                    </div>
                <? endif; ?>
            <? endforeach; ?>
        </div>
    </div>
    <div class="chat_bottom">
        <form class="chat_form">
            <input type="text" class="chat_input" id="user-message" placeholder="Введите сообщение">
            <button class="chat_btn" id="send-message">Отправить</button>
        </form>
    </div>
</div>
<script>
    window.addEventListener("load", (event) => {
        let chat = new Chat(<?=CUtil::PhpToJSObject($JS_DATA)?>);
        chat.init();
    });
</script>