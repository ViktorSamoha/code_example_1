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

$APPLICATION->SetTitle("Создание заказа");

$manager = getUserData();

?>
<form action="" class="form" id="order-form">
    <div class="form-item-group">
        <div class="form-item form-item--md">
            <label for="" class="label">Услуга</label>
            <div class="custom-select" id="service-select">
                <div class="custom-select_head">
                    <? if (isset($arResult['SELECTED_SERVICE']) && !empty($arResult['SELECTED_SERVICE'])): ?>
                        <span class="custom-select_title"
                              data-selected-id="<?= $arResult['SELECTED_SERVICE']['ID'] ?>"><?= $arResult['SELECTED_SERVICE']['NAME'] ?></span>
                    <? else: ?>
                        <span class="custom-select_title">Выберите услугу</span>
                    <? endif; ?>
                    <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L8 8L15 1" stroke="black"/>
                    </svg>
                </div>
                <div class="custom-select_body">
                    <? foreach ($arResult['SERVICE_LIST'] as $service): ?>
                        <div class="custom-select_item" data-id="<?= $service['ID'] ?>"><?= $service['NAME'] ?></div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-item-group">
        <div class="form-item form-item--md">
            <label for="" class="label">Контрагент</label>
            <div class="custom-select" id="customer-select">
                <div class="custom-select_head">
                    <? if (isset($arResult['SELECTED_USER']) && !empty($arResult['SELECTED_USER'])): ?>
                        <span class="custom-select_title"
                              data-selected-id="<?= $arResult['SELECTED_USER']['ID'] ?>"><?= $arResult['SELECTED_USER']['WORK_COMPANY'] ?></span>
                    <? else: ?>
                        <span class="custom-select_title">Выберите контрагента</span>
                    <? endif; ?>
                    <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L8 8L15 1" stroke="black"/>
                    </svg>
                </div>
                <div class="custom-select_body">
                    <? foreach ($arResult['USER_LIST'] as $user): ?>
                        <div class="custom-select_item" data-id="<?= $user['ID'] ?>"><?= $user['WORK_COMPANY'] ?></div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
        <div class="form-item form-item--md">
            <button class="btn-create-item js-open-modal" data-name="modal-add-counterparty">
                <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M13.668 6.86914V8.41406H0.0234375V6.86914H13.668ZM7.61133 0.511719V15.0039H5.9707V0.511719H7.61133Z"
                            fill="#DE6396"/>
                </svg>
                <span>Добавить контрагента</span>
            </button>
        </div>
    </div>
    <h2 class="h2">Этапы заказа</h2>

    <h3 class="h3">Этап 1</h3>
    <div class="form-item-group">
        <div class="form-item form-item--md">
            <label for="" class="label">Наименование работ</label>
            <div class="custom-select" id="work-type-select-stage-1">
                <div class="custom-select_head">
                    <span class="custom-select_title">Выберите вид работ</span>
                    <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L8 8L15 1" stroke="black"/>
                    </svg>
                </div>
                <div class="custom-select_body">
                    <? foreach ($arResult['WORK_TYPES_LIST'] as $workType): ?>
                        <div class="custom-select_item" data-id="<?= $workType['ID'] ?>"><?= $workType['NAME'] ?></div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
        <div class="form-item form-item--md">
            <button class="btn-create-item js-open-modal" data-name="modal-add-type-of-work">
                <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M13.668 6.86914V8.41406H0.0234375V6.86914H13.668ZM7.61133 0.511719V15.0039H5.9707V0.511719H7.61133Z"
                            fill="#DE6396"/>
                </svg>
                <span>Добавить вид работ</span>
            </button>
        </div>

        <div class="form-item">
            <div class="m-input-dates js-input-date-group">
                <div class="m-input-date-block">
                    <label for="" class="input-label">Дата начала</label>
                    <input type="text" class="input-date" id="first-input-date-stage-1">
                </div>
                <div class="m-input-date-block">
                    <label for="" class="input-label">Дата завершения</label>
                    <input type="text" class="input-date second-range-input" id="second-input-date-stage-1">
                </div>
            </div>
        </div>
    </div>
    <div class="form-item-group" id="executor-node">
        <div class="form-item form-item--md">
            <label for="" class="label">Ответственный</label>
            <div class="custom-select" id="executor-select">
                <div class="custom-select_head">
                    <span class="custom-select_title">Выберите ответственного</span>
                    <svg width="16" height="9" viewBox="0 0 16 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L8 8L15 1" stroke="black"/>
                    </svg>
                </div>
                <div class="custom-select_body">
                    <? foreach ($arResult['EXECUTOR_LIST'] as $executor): ?>
                        <div class="custom-select_item"
                             data-id="<?= $executor['ID'] ?>"><?= $executor['LAST_NAME'] . ' ' . $executor['NAME'] . ' ' . $executor['SECOND_NAME'] ?></div>
                    <? endforeach; ?>
                </div>
            </div>
        </div>
        <? if ($manager['IS_ADMIN']): ?>
            <div class="form-item form-item--md">
                <button class="btn-create-item js-open-modal" data-name="modal-add-user">
                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M13.668 6.86914V8.41406H0.0234375V6.86914H13.668ZM7.61133 0.511719V15.0039H5.9707V0.511719H7.61133Z"
                                fill="#DE6396"/>
                    </svg>
                    <span>Добавить сотрудника</span>
                </button>
            </div>
        <? endif; ?>
    </div>

    <button class="btn-create-block" data-stage-number="1" id="create-stage-btn">
        <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                    d="M13.668 6.86914V8.41406H0.0234375V6.86914H13.668ZM7.61133 0.511719V15.0039H5.9707V0.511719H7.61133Z"
                    fill="#313131"/>
        </svg>
        <span>Добавить этап</span>
    </button>
    <button class="btn-secondary" id="create-order-btn">Создать заказ</button>
</form>
<?

$order = [
    'WORK_TYPES_LIST' => $arResult['WORK_TYPES_LIST'],
    'EXECUTOR_LIST' => $arResult['EXECUTOR_LIST'],
    'STAGE_COUNT' => 1,
    'WAITING_LIST_ELEMENT_ID' => $_REQUEST['req'] ?? '',
];

?>
<script>
    window.addEventListener("load", (event) => {
        let order = new Order(<?=CUtil::PhpToJSObject($order)?>);
        order.init();
    });
</script>