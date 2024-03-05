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
$session = \Bitrix\Main\Application::getInstance()->getSession();

$session->set('chat_manager_id', $arResult['EXECUTOR']['ID']);
$session->set('chat_user_id', $arResult['CUSTOMER']['ID']);
$session->set('chat_order_id', $arResult['ORDER_ID']);

?>
<div class="project">
    <div class="project_left">
        <h3 class="h3">Стадия работ</h3>

        <div class="table-wrap table-wrap--pb">
            <table class="table">
                <tr>
                    <th>Этап</th>
                    <th>Срок исполнения</th>
                    <th>Статус</th>
                </tr>
                <? foreach ($arResult['STAGES'] as $stageId => $arStage): ?>
                    <tr>
                        <td><?= $arStage['TYPE'] ?></td>
                        <td class="text-center"><?= $arStage['PERIOD'] ?> рабочих дней</td>
                        <? if ($user['IS_SIMPLE_USER']): ?>
                            <?
                            switch ($arStage['SELECTED_STATUS']['VALUE']) {
                                case 'В ожидании':
                                    ?>
                                    <td class="text-center">
                                        <span class="color_gray">В ожидании</span>
                                    </td>
                                    <?
                                    break;
                                case 'На исполнении':
                                    ?>
                                    <td class="text-center bg_green">
                                        На исполнении
                                        <span class="sm-text">Срок: с <?= $arStage['FROM'] ?> до <?= $arStage['TO'] ?> </span>
                                    </td>
                                    <?
                                    break;
                                case 'Завершено':
                                    ?>
                                    <td class="text-center bg_pink">Завершено</td>
                                    <?
                                    break;
                            }
                            ?>
                        <? else: ?>
                            <td class="text-center">
                                <div class="custom-select">
                                    <div class="custom-select_head">
                                        <? if (isset($arStage['SELECTED_STATUS'])): ?>
                                            <span class="custom-select_title"
                                                  data-selected-id="<?= $arStage['SELECTED_STATUS']['ID'] ?>"
                                                  data-stage-id="<?= $stageId ?>"><?= $arStage['SELECTED_STATUS']['VALUE'] ?></span>
                                        <? else: ?>
                                            <span class="custom-select_title">Укажите статус</span>
                                        <? endif; ?>
                                        <svg width="16" height="9" viewBox="0 0 16 9" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1L8 8L15 1" stroke="black"/>
                                        </svg>
                                    </div>
                                    <div class="custom-select_body">
                                        <?
                                        foreach ($arStage['STATUS'] as $stageStatus):
                                            ?>
                                            <div class="custom-select_item"
                                                 data-id="<?= $stageStatus['ID'] ?>">
                                                <?= $stageStatus['VALUE']; ?>
                                            </div>
                                        <? endforeach; ?>
                                    </div>
                                </div>
                            </td>
                        <? endif; ?>
                    </tr>
                <? endforeach; ?>
            </table>
        </div>
    </div>
    <? if ($user['IS_SIMPLE_USER']): ?>
        <div class="project_right">
            <div class="p-card">
                <span class="p-card_title">Ваш менеджер</span>
                <div class="p-card_img">
                    <? if ($arResult['EXECUTOR']['PERSONAL_PHOTO']): ?>
                        <img src="<?= $arResult['EXECUTOR']['PERSONAL_PHOTO'] ?>" alt="">
                    <? else: ?>
                        <img src="<?= ASSETS ?>images/input-file_icon.svg" alt="">
                    <? endif; ?>
                </div>
                <span class="p-card_subtitle"><?= $arResult['EXECUTOR']['LAST_NAME'] . ' ' . $arResult['EXECUTOR']['NAME'] . ' ' . $arResult['EXECUTOR']['SECOND_NAME'] ?></span>
                <button class="btn-primary btn-primary--sm js-open-modal" type="button"
                        data-name="modal-chat">Написать
                </button>
                <div class="social-links">
                    <? if (isset($arResult['EXECUTOR']['TELEGRAM'])): ?>
                        <a href="https://t.me/<?= $arResult['EXECUTOR']['TELEGRAM'] ?>" class="social-links_item"
                           target="_blank">
                            <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M15.32 16.8123C15.5883 17.0061 15.9341 17.0545 16.2425 16.9355C16.5508 16.8157 16.7775 16.5471 16.8458 16.2215C17.5699 12.7501 19.3266 3.96368 19.9857 0.805927C20.0357 0.567927 19.9524 0.320576 19.7691 0.161626C19.5857 0.00267605 19.3316 -0.0432241 19.1049 0.042626C15.6108 1.36183 4.85022 5.48008 0.451988 7.14013C0.172828 7.24553 -0.00883492 7.51923 0.000331537 7.81928C0.0103313 8.12018 0.20866 8.38114 0.494487 8.46869C2.46694 9.07049 5.05605 9.90774 5.05605 9.90774C5.05605 9.90774 6.26602 13.635 6.89684 15.5305C6.97601 15.7685 7.1585 15.9555 7.39933 16.0201C7.63932 16.0838 7.89599 16.0167 8.07515 15.8441C9.08846 14.8683 10.6551 13.3596 10.6551 13.3596C10.6551 13.3596 13.6317 15.5857 15.32 16.8123ZM6.14519 9.43684L7.54433 14.1441L7.85515 11.1632C7.85515 11.1632 13.2609 6.18983 16.3425 3.35508C16.4325 3.27178 16.445 3.13238 16.37 3.03463C16.2958 2.93688 16.1591 2.91393 16.0566 2.98023C12.485 5.30668 6.14519 9.43684 6.14519 9.43684Z"
                                      fill="#DE6396"/>
                            </svg>
                        </a>
                    <? endif; ?>
                    <? if (isset($arResult['EXECUTOR']['WHATSAPP'])): ?>
                        <a href="https://wa.me/<?= $arResult['EXECUTOR']['WHATSAPP'] ?>" class="social-links_item"
                           target="_blank">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M9.31612 17.9981C7.68685 18.0291 6.07367 17.6733 4.61047 16.9603L0.24462 17.8119L1.09102 13.5273C-1.79209 8.2048 1.09102 0 9.12254 0C20.9639 0 20.8897 17.9981 9.31612 17.9981ZM9.52206 10.9541L7.14761 8.66949L7.8725 7.34296L6.96639 3.79738L4.15947 3.88745C4.15947 3.88745 2.92385 7.43713 7.04258 11.5334C11.1613 15.6296 14.1494 14.2192 14.1494 14.2192L14.376 11.1731L10.8751 10.2621L9.52206 10.9541Z"
                                      fill="#DE6396"/>
                            </svg>
                        </a>
                    <? endif; ?>
                </div>
            </div>
            <div class="doc-list">
                <? foreach ($arResult['DOCS'] as $arDoc): ?>
                    <div class="doc-item">
                        <span class="doc-item_title"><?= $arDoc['ORIGINAL_NAME'] ?></span>
                        <a href="<?= $arDoc['SRC'] ?>" class="doc-item_link">(скачать)</a>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    <? else: ?>
        <div class="project_right">
            <div class="p-card">
                <? if (!empty($arResult['CUSTOMER'])): ?>
                    <? if ($arResult['CUSTOMER']['WORK_COMPANY'] != ''): ?>
                        <span class="p-card_title"><?= $arResult['CUSTOMER']['WORK_COMPANY'] ?></span>
                    <? else: ?>
                        <span class="p-card_title">Заказчик</span>
                    <? endif; ?>
                    <div class="p-card_img">
                        <? if ($arResult['CUSTOMER']['PERSONAL_PHOTO']): ?>
                            <img src="<?= $arResult['CUSTOMER']['PERSONAL_PHOTO'] ?>" alt="">
                        <? else: ?>
                            <img src="<?= ASSETS ?>images/input-file_icon.svg" alt="">
                        <? endif; ?>
                    </div>
                    <? if ($arResult['CUSTOMER']['LAST_NAME'] != ''
                        && $arResult['CUSTOMER']['NAME'] != ''
                        && $arResult['CUSTOMER']['SECOND_NAME'] != ''): ?>
                        <span class="p-card_subtitle">
                            <?= $arResult['CUSTOMER']['LAST_NAME'] . ' ' . $arResult['CUSTOMER']['NAME'] . ' ' . $arResult['CUSTOMER']['SECOND_NAME']; ?>
                        </span>
                    <? endif; ?>
                <? endif; ?>
                <button class="btn-primary btn-primary--sm js-open-modal" type="button"
                        data-name="modal-chat">Чат
                </button>
                <div class="social-links">
                    <? if (isset($arResult['CUSTOMER']['TELEGRAM'])): ?>
                        <a href="https://t.me/<?= $arResult['CUSTOMER']['TELEGRAM'] ?>" class="social-links_item"
                           target="_blank">
                            <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M15.32 16.8123C15.5883 17.0061 15.9341 17.0545 16.2425 16.9355C16.5508 16.8157 16.7775 16.5471 16.8458 16.2215C17.5699 12.7501 19.3266 3.96368 19.9857 0.805927C20.0357 0.567927 19.9524 0.320576 19.7691 0.161626C19.5857 0.00267605 19.3316 -0.0432241 19.1049 0.042626C15.6108 1.36183 4.85022 5.48008 0.451988 7.14013C0.172828 7.24553 -0.00883492 7.51923 0.000331537 7.81928C0.0103313 8.12018 0.20866 8.38114 0.494487 8.46869C2.46694 9.07049 5.05605 9.90774 5.05605 9.90774C5.05605 9.90774 6.26602 13.635 6.89684 15.5305C6.97601 15.7685 7.1585 15.9555 7.39933 16.0201C7.63932 16.0838 7.89599 16.0167 8.07515 15.8441C9.08846 14.8683 10.6551 13.3596 10.6551 13.3596C10.6551 13.3596 13.6317 15.5857 15.32 16.8123ZM6.14519 9.43684L7.54433 14.1441L7.85515 11.1632C7.85515 11.1632 13.2609 6.18983 16.3425 3.35508C16.4325 3.27178 16.445 3.13238 16.37 3.03463C16.2958 2.93688 16.1591 2.91393 16.0566 2.98023C12.485 5.30668 6.14519 9.43684 6.14519 9.43684Z"
                                      fill="#DE6396"/>
                            </svg>
                        </a>
                    <? endif; ?>
                    <? if (isset($arResult['CUSTOMER']['WHATSAPP'])): ?>
                        <a href="https://wa.me/<?= $arResult['CUSTOMER']['WHATSAPP'] ?>" class="social-links_item"
                           target="_blank">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M9.31612 17.9981C7.68685 18.0291 6.07367 17.6733 4.61047 16.9603L0.24462 17.8119L1.09102 13.5273C-1.79209 8.2048 1.09102 0 9.12254 0C20.9639 0 20.8897 17.9981 9.31612 17.9981ZM9.52206 10.9541L7.14761 8.66949L7.8725 7.34296L6.96639 3.79738L4.15947 3.88745C4.15947 3.88745 2.92385 7.43713 7.04258 11.5334C11.1613 15.6296 14.1494 14.2192 14.1494 14.2192L14.376 11.1731L10.8751 10.2621L9.52206 10.9541Z"
                                      fill="#DE6396"/>
                            </svg>
                        </a>
                    <? endif; ?>
                </div>
            </div>
            <div class="doc-list">
                <? foreach ($arResult['DOCS'] as $arDoc): ?>
                    <div class="doc-item">
                        <span class="doc-item_title"><?= $arDoc['ORIGINAL_NAME'] ?></span>
                        <a href="<?= $arDoc['SRC'] ?>" class="doc-item_link">(скачать)</a>
                    </div>
                <? endforeach; ?>
            </div>
            <? if (!$arParams["ARCHIVE_ORDER"]): ?>
                <div class="input-file-group">
                    <div class="input-file">
                        <form id="upload-order-doc" enctype="multipart/form-data">
                            <input id="order-doc" type="file" name="ORDER_DOC">
                            <input type="hidden" name="ORDER_ID" value="<?= $arResult['ID'] ?>">
                            <label for="order-doc">Прикрепить файл</label>
                            <div class="input-file_name">(максимальный размер файла 3 Мб)</div>
                        </form>
                        <span id="order-doc-msg"></span>
                    </div>
                </div>
                <a href="/personal/edit_order/?id=<?= $arResult['ORDER_ID'] ?>" class="btn-secondary">Редактировать
                    заказ</a>
            <? endif; ?>
        </div>
    <? endif; ?>
</div>
<?
$JS_DATA = [
    'ORDER_ID' => $arResult['ID'],
    'STAGES' => $arResult['STAGES'],
    'CUSTOMER' => $arResult['PROPERTIES']['CUSTOMER']['VALUE'],
];
?>
<script>
    window.addEventListener("load", (event) => {
        let stages = new Stages(<?=CUtil::PhpToJSObject($JS_DATA)?>);
        stages.init();
    });
</script>