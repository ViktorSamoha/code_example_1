<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult)): ?>
    <div class="menu">
        <div class="menu-content">
            <nav class="nav">
                <div class="nav_column">
                    <div class="nav_item">
                        <a href="/" class="nav_link">Главная страница</a>
                    </div>
                    <div class="nav_item">
                        <a href="/auth/" class="nav_link">Вход в личный кабинет</a>
                    </div>
                    <div class="nav_item">
                        <a href="/auth/registration.php?register=yes" class="nav_link">Регистрация</a>
                    </div>
                    <div class="nav_item">
                        <a href="/search/" class="nav_link">Поиск</a>
                    </div>
                </div>
                <div class="nav_column">
                    <div class="nav_item mb0">
                        <a href="javascript:void(0);" class="nav_link">Услуги</a>
                        <div class="submenu">
                            <? foreach ($arResult['SECOND_MENU'] as $arSecondMenuItem): ?>
                                <? if (isset($arSecondMenuItem['CHILDS']) && !empty($arSecondMenuItem['CHILDS'])): ?>
                                    <div class="submenu_item">
                                        <a href="<?= $arSecondMenuItem["LINK"] ?>"
                                           class="submenu_link link-animated"><?= $arSecondMenuItem["NAME"] ?></a>
                                        <div class="lv3">
                                            <? foreach ($arSecondMenuItem['CHILDS'] as $childMenuItem): ?>
                                                <a href="<?= $childMenuItem["LINK"] ?>"
                                                   class="lv3_link link-animated"><?= $childMenuItem["NAME"] ?></a>
                                            <? endforeach ?>
                                        </div>
                                    </div>
                                <? else: ?>
                                    <a href="<?= $arSecondMenuItem["LINK"] ?>"
                                       class="submenu_link link-animated"><?= $arSecondMenuItem["NAME"] ?></a>
                                <? endif; ?>

                            <? endforeach ?>
                        </div>
                    </div>
                </div>
                <div class="nav_column">
                    <div class="nav_item">
                        <div class="submenu">
                            <? foreach ($arResult['MENU'] as $arItem):
                                if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                                    continue;
                                ?>
                                <a href="<?= $arItem["LINK"] ?>"
                                   class="submenu_link link-animated"><?= $arItem["TEXT"] ?></a>
                            <? endforeach ?>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
<? endif ?>