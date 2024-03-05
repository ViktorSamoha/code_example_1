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

$APPLICATION->SetTitle("Заказать услугу");
?>
<h4 class="h4">Выберите услугу</h4>
<form action="" class="form">
    <div class="form-item-group">
        <div class="form-item form-item--md">
            <label for="" class="label">Услуги</label>
            <div class="custom-select" id="service-list">
                <div class="custom-select_head">
                    <span class="custom-select_title">Выберите услугу</span>
                    <svg width="16" height="9" viewBox="0 0 16 9" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L8 8L15 1" stroke="black"/>
                    </svg>
                </div>

                <div class="custom-select_body">
                    <? foreach ($arResult['SERVICES'] as $service): ?>
                        <div class="custom-select_item"
                             data-id="<?= $service['ID'] ?>"><?= $service['NAME'] ?></div>
                    <? endforeach; ?>
                </div>

            </div>
        </div>
        <div class="form-item form-item--md">
            <a href="#" class="doc" target="_blank">
                <svg width="24" height="30" viewBox="0 0 24 30" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M3.16536 29.5C2.50286 29.5 1.94835 29.2767 1.50182 28.8302C1.0553 28.3837 0.832031 27.8292 0.832031 27.1667V2.83333C0.832031 2.17083 1.0553 1.61632 1.50182 1.16979C1.94835 0.723264 2.50286 0.5 3.16536 0.5H16.582L23.1654 7.08333V27.1667C23.1654 27.8292 22.9421 28.3837 22.4956 28.8302C22.049 29.2767 21.4945 29.5 20.832 29.5H3.16536ZM16.082 7.55554V1.5H3.16536C2.83203 1.5 2.52648 1.63889 2.2487 1.91667C1.97092 2.19444 1.83203 2.5 1.83203 2.83333V27.1667C1.83203 27.5 1.97092 27.8056 2.2487 28.0833C2.52648 28.3611 2.83203 28.5 3.16536 28.5H20.832C21.1654 28.5 21.4709 28.3611 21.7487 28.0833C22.0265 27.8056 22.1654 27.5 22.1654 27.1667V7.55554H16.082Z"
                            fill="#DE6396"/>
                    <path
                            d="M11.6464 21.3536C11.8417 21.5488 12.1583 21.5488 12.3536 21.3536L15.5355 18.1716C15.7308 17.9763 15.7308 17.6597 15.5355 17.4645C15.3403 17.2692 15.0237 17.2692 14.8284 17.4645L12 20.2929L9.17157 17.4645C8.97631 17.2692 8.65973 17.2692 8.46447 17.4645C8.2692 17.6597 8.2692 17.9763 8.46447 18.1716L11.6464 21.3536ZM11.5 12L11.5 21L12.5 21L12.5 12L11.5 12Z"
                            fill="#DE6396"/>
                </svg>
                <span>Скачайте Опросный лист или свяжитесь с нами для консультации</span>
            </a>
        </div>
    </div>
    <button class="btn-secondary" id="confirm-order">Заказать услугу</button>
    <div id="form-error-msg"></div>
    <div id="form-success-msg"></div>
</form>
<script>
    window.addEventListener("load", (event) => {
        let service_form = new ServiceForm(<?=CUtil::PhpToJSObject($arResult['USER'])?>);
        service_form.init();
    });
</script>