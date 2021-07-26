<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use app\Orm\ProfilesTable;
use Bitrix\Main\Type;
use \Bitrix\Main\Engine\ActionFilter;
use \Bitrix\Main\Engine\Contract\Controllerable;


/**
 * Class ProfileManager
 */
class ProfileManagerComponent extends CBitrixComponent implements Controllerable
{
    /**
     * @return mixed|void
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function executeComponent()
    {
        $this->includeComponentTemplate();
    }

    /**
     * Получаем данные выбранного профиля
     * @param $iProfileID
     * @return bool
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function processAction($name,$url)
    {
        $result = ProfilesTable::add([
            'NAME' => $name,
            'URL' => $url,
        ]);

        if ($result->isSuccess())
        {
            $id = $result->getId();
            //echo $id;
        }

        return $id;
    }

    /**
     * @return array
     */
    public function configureActions()
    {
        return [
            'process' => [
                'prefilters' => [
                    new ActionFilter\Authentication(),
                    new ActionFilter\HttpMethod([ActionFilter\HttpMethod::METHOD_POST]),
                    new ActionFilter\Csrf(),
                ],
                'postfilters' => []
            ],
        ];
    }

}