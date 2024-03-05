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

?>
<form action="" class="form-registration-user" id="form-add-user-post">
    <div class="form-item">
        <label for="USER_POST" class="label">Наименование должности</label>
        <input type="text" class="input" name="USER_POST">
    </div>
    <button class="btn-secondary" id="add-user-post-create">Добавить должность</button>
</form>
<div id="form-error-msg"></div>
<script>
    window.addEventListener("load", (event) => {
        let _post = new _Post();
        _post.init();
    });
</script>