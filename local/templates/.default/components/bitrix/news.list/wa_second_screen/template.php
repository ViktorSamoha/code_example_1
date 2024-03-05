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
<section class="section">
    <div class="screen">
        <div class="content-wrap">
            <h2 class="title"><?= $arResult['NAME'] ?></h2>
            <div class="catalog">
                <? foreach ($arResult['ITEMS'] as $item): ?>
                    <?
                    $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <a href="/service/<?= $item['CODE'] ?>/" class="catalog-item"
                       id="<?= $this->GetEditAreaId($item['ID']); ?>">
                        <span class="catalog-item_title"><?= $item['NAME'] ?></span>
                        <div class="catalog-item_icon">
                            <img src="<?= $item['ICON'] ?>" alt="<?= $item['NAME'] ?>">
                        </div>
                    </a>
                <? endforeach; ?>
            </div>
        </div>
    </div>
</section>