<?php

defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use \Bitrix\Main\EventManager;

$oEventManager = EventManager::getInstance();
$oEventManager->addEventHandler('main', 'OnBuildGlobalMenu', function (&$arGlobalMenu, &$arModuleMenu)
{

    $sModule = str_replace('.', '_', basename(dirname(dirname(__FILE__))));

    $arMenu = array();
    $sKeyMenu = '';

    $sGlobalMenu = 'global_menu_services'; // по-умолчанию ставим родительский раздел Сервисы

    foreach ($arModuleMenu as $sKey => $arVal) {
        if ($arVal['parent_menu'] === $sGlobalMenu && $arVal['section'] === $sModule) {
            $sKeyMenu = $sKey;
            $arMenu = $arVal;
            break;
        }
    }

    if (empty($arMenu)) {
        $arMenu = array(
            'parent_menu' => $sGlobalMenu,
            'section' => $sModule,
            'sort' => 0,
            'text' => 'Дополнительные настройки',
            'title' => 'Дополнительные настройки',
            'icon' => 'Дополнительные настройки',
            'page_icon' => 'update_menu_icon',
            'items_id' => 'menu_'.$sModule,
            'items' => array(),
        );
    }

    $arMenu['items'][] = array(
        'text' => 'Настройки',
        'title' => 'Настройки',
        'url' => "params.php",
        'more_url' => array(
            "params.php"
        )
    );

    if ($sKeyMenu) {
        $arModuleMenu[$sKeyMenu] = $arMenu;
    } else {
        $arModuleMenu[] = $arMenu;
    }
});