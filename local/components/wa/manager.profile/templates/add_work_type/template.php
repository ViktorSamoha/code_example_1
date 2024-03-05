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

if ($arParams['ADD_TITLE']) {
    $APPLICATION->SetTitle("Добавление вида работ");
}

?>
<form action="" class="form-registration-user" id="form-add-work-type">
    <div class="form-item">
        <label for="NAME" class="label">Наименование работ</label>
        <input type="text" class="input" name="NAME">
    </div>
    <button class="btn-secondary" id="add-work-type">Добавить вид работ</button>
</form>
<div id="form-error-msg"></div>
<script>
    window.addEventListener("load", (event) => {
        let workType = new WorkType();
        workType.init();
    });
</script>