<?php
//подключаем класс и файлы локализации
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
//добавляем пункт
$menu = array(
    array(
        'parent_menu' => 'global_menu_services',//определяем место меню
        'sort' => 1,//сортировка
        'text' => Loc::getMessage('MYMODULE_MENU_TITLE'),//описание из файла локализации
        'title' => Loc::getMessage('MYMODULE_MENU_TITLE'),//название из файла локализации
        'url' => 'new_menu.php',//ссылка на страницу из меню
        'items_id' => 'menu_references',//описание подпункта
        'items' => array(
            array(
                'text' => Loc::getMessage('MYMODULE_SUBMENU_TITLE'),
                'url' => 'new_menu.php?lang=' . LANGUAGE_ID,
                'more_url' => array('new_menu.php?lang=' . LANGUAGE_ID),
                'title' => Loc::getMessage('MYMODULE_SUBMENU_TITLE'),
            ),
        ),
    ),
);

return $menu;