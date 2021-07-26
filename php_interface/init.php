<?php
AddEventHandler('iblock', 'OnBeforeIBlockElementAdd', 'IBEventForm');

function IBEventForm(&$arFields)
{
    $SITE_ID = 's1'; //Индетификатор сайта
    $IBLOCK_ID = 23; //Индетификатор инфоблока с новостями
    $EVEN_TYPE = 'NEW_ELEMENT_ADDED'; // Тип почтового события

    if ($arFields['IBLOCK_ID'] == $IBLOCK_ID) {

        //Собираем в массив все данные, которые хотим передать в письмо
        $arEventForm = array(

            "ADD_NAME" => $arFields['NAME'],
            "ADD_EVENT" => $arFields['PROPERTY_VALUES']['93'],
            "ADD_THEME" => $arFields['PROPERTY_VALUES']['94'],
            "ADD_AUTHOR" => $arFields['PROPERTY_VALUES']['95'],

        );

        define('LOG_FILENAME', $_SERVER['DOCUMENT_ROOT'].'/local/log.txt');
        AddMessage2Log($arEventForm);

        //почтовое событие
        CEvent::Send($EVEN_TYPE, $SITE_ID, $arEventForm );
    }
}
require_once __DIR__ . '/../app/Orm/ProfilesTable.php';