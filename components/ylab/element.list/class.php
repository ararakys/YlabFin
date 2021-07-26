<?php

namespace YLab\Components;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\UI\Filter\Options;
use Bitrix\Main\UI\PageNavigation;
use CBitrixComponent;
use CIBlockElement;
use Exception;
use Bitrix\Main\Loader;

/**
 * Class ElementListComponent
 * @package YLab\Components
 * Компонент отображения списка элементов нашего ИБ
 */
class ElementListComponent extends CBitrixComponent
{
    /** @var int $idIBlock ID информационого блока */
    private $idIBlock;

    /**
     * Метод executeComponent
     *
     * @return mixed|void
     * @throws ArgumentException
     * @throws LoaderException
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws Exception
     */
    public function executeComponent()
    {
        Loader::includeModule('iblock');

        $this->idIBlock = self::getIBlockIdByCode('home_work');

        //$this->arResult['ITEMS'] = $this->getElements();

        $this->showByGrid();

        $this->includeComponentTemplate();
    }

    /**
     * Получим элементы ИБ
     * @return array
     */
    public function getElements(): array
    {
        if (!$this->getGridNav()->allRecordsShown()) {
            $arNav['iNumPage'] = $this->getGridNav()->getCurrentPage();
            $arNav['nPageSize'] = $this->getGridNav()->getPageSize();
        } else {
            $arNav = false;
        }

        $sort = $this->getObGridParams()->getSorting(['sort' => ['ID' => 'DESC']])['sort'];

//фильтр
        $filterOption = new Options($arResult['GRID']['GRID_ID'] . '_filter');
        $filterData = $filterOption->getFilter([]);
        $filter = [];

        foreach ($filterData as $k => $v) {

            $filter['>=PROPERTY_PRICE'] = $filterData["PRICE_from"];
            $filter['<=PROPERTY_PRICE'] = $filterData["PRICE_to"];

            $filter['>=PROPERTY_PERCENT'] = $filterData['PERCENT_from'];
            $filter['<=PROPERTY_PERCENT'] = $filterData['PERCENT_to'];

            if($filterData['STATUS']=="in_work") {
                $filter['PROPERTY_STATUS_VALUE'] = "%В%работе%";
            }elseif ($filterData['STATUS']=="done") {
                $filter['PROPERTY_STATUS_VALUE'] = "%Готово%";
            }else{
                $filter['PROPERTY_STATUS_VALUE'] = "%";
            }

            $filter[">PROPERTY_DATE"] = ConvertDateTime($filterData["DATE_from"], "YYYY-MM-DD")."";
            $filter["<PROPERTY_DATE"] = ConvertDateTime($filterData["DATE_to"], "YYYY-MM-DD")."";

            //$filter['NAME'] = "%".$filterData['FIND']."%";
        }
        //var_dump($filter);

        $elements = CIBlockElement::GetList(
            $sort,
            ['IBLOCK_ID' => $this->idIBlock, $filter],
            false,
            $arNav,
            ['ID', 'IBLOCK_ID', 'PROPERTY_PRICE', 'PROPERTY_PERCENT', 'PROPERTY_STATUS', 'PROPERTY_DATE']
        );


        $result = [];

        $this->getGridNav()->setRecordCount($elements->selectedRowsCount());

        while ($element = $elements->GetNext()) {

            $total = $element['PROPERTY_PRICE_VALUE'] + (round(((int)$element['PROPERTY_PRICE_VALUE'] * (int)$element['PROPERTY_PERCENT_VALUE']) / 100));

            $result[] = [
                'ID' => $element['ID'],
                'PRICE' => $element['PROPERTY_PRICE_VALUE'],
                'PERCENT' => $element['PROPERTY_PERCENT_VALUE'],
                'TOTAL' => $total,
                'STATUS' => $element['PROPERTY_STATUS_VALUE'],
                'DATE' => $element['PROPERTY_DATE_VALUE']
            ];
        }

        return $result;
    }

    /**
     * Отображение через грид
     */
    public function showByGrid()
    {
        $this->arResult['GRID_ID'] = $this->getGridId();
        $this->arResult['GRID_NAV'] = $this->getGridNav();
        $this->arResult['GRID_BODY'] = $this->getGridBody();
        $this->arResult['GRID_HEAD'] = $this->getGridHead();
        $this->arResult['GRID_FILTER'] = $this->getGridFilterParams();

        $this->arResult['BUTTONS']['ADD']['NAME'] = Loc::getMessage('YLAB.ELEMENT.LIST.CLASS.ADD');
    }

    /**
     * Возвращает содержимое (тело) таблицы.
     *
     * @return array
     */
    private function getGridBody(): array
    {
        $arBody = [];

        $arItems = $this->getElements();

        foreach ($arItems as $arItem) {
            $arGridElement = [];

            $arGridElement['data'] = [
                'ID' => $arItem['ID'],
                'PRICE' => $arItem['PRICE'],
                'PERCENT' => !empty($arItem['PERCENT']) ? $arItem['PERCENT'] : '',
                'TOTAL' => !empty($arItem['TOTAL']) ? $arItem['TOTAL'] : '',
                'STATUS' => !empty($arItem['STATUS']) ? $arItem['STATUS'] : '',
                'DATE' => !empty($arItem['DATE']) ? $arItem['DATE'] : ''
            ];

            $arBody[] = $arGridElement;

        }
        //print_r($arBody);
        return $arBody;
    }

    /**
     * Возвращает идентификатор грида.
     *
     * @return string
     */
    private function getGridId(): string
    {
        return 'ylab_elements_list_' . $this->idIBlock;
    }

    /**
     * возвращает настройки отображения грид фильтра.
     *
     * @return array
     */
    private function getGridFilterParams(): array
    {
        return [
            [
                'id' => 'ID',
                'name' => 'ID',
                'type' => 'number'
            ],
            [
                'id' => 'PROPERTY_PRICE_VALUE',
                'name' => Loc::getMessage('YLAB.ELEMENT.LIST.CLASS.PRICE'),
                'type' => 'number'
            ],
        ];
    }

    /**
     * Возращает заголовки таблицы.
     *
     * @return array
     */
    private function getGridHead(): array
    {
        return [
            [
                'id' => 'ID',
                'name' => 'ID',
                'default' => true,
                'sort' => 'ID',
            ],
            [
                'id' => 'PRICE',
                'name' => Loc::getMessage('YLAB.ELEMENT.LIST.CLASS.PRICE'),
                'default' => true,
                'sort' => 'PROPERTY_PRICE',
            ],
            [
                'id' => 'PERCENT',
                'name' => Loc::getMessage('YLAB.ELEMENT.LIST.CLASS.PERCENT'),
                'default' => true,
            ],
            [
                'id' => 'TOTAL',
                'name' => Loc::getMessage('YLAB.ELEMENT.LIST.CLASS.TOTAL'),
                'default' => true,
            ],
            [
                'id' => 'STATUS',
                'name' => Loc::getMessage('YLAB.ELEMENT.LIST.CLASS.STATUS'),
                'default' => true,
                'sort' => 'PROPERTY_STATUS',
            ],
            [
                'id' => 'DATE',
                'name' => Loc::getMessage('YLAB.ELEMENT.LIST.CLASS.DATE'),
                'default' => true,
                'sort' => 'PROPERTY_DATE',
            ],
        ];
    }

    /**
     * Возвращает единственный экземпляр настроек грида.
     *
     * @return GridOptions
     */
    private function getObGridParams(): GridOptions
    {
        return $this->gridOption ?? $this->gridOption = new GridOptions($this->getGridId());
    }

    /**
     * Параметры навигации грида
     *
     * @return PageNavigation
     */

    private function getGridNav(): PageNavigation
    {
        if ($this->gridNav === null) {
            $this->gridNav = new PageNavigation($this->getGridId());
            $this->gridNav
                ->allowAllRecords(true)
                ->setPageSize($this->getObGridParams()->GetNavParams()['nPageSize'])
                ->initFromUri();

            /*if ($this->gridNav->allRecordsShown()) {
                $this->getObGridParams()->GetNavParams()['nPageSize'] = false;
            } else {
                $this->getObGridParams()->GetNavParams()['iNumPage'] = $this->gridNav->getCurrentPage();
            }*/
        }
        return $this->gridNav;

    }

    /**
     * Метод возвращает ID инфоблока по символьному коду
     *
     * @param $code
     *
     * @return int|void
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws Exception
     */
    public static function getIBlockIdByCode($code)
    {
        $IB = IblockTable::getList([
            'select' => ['ID'],
            'filter' => ['CODE' => $code],
            'limit' => '1',
            'cache' => ['ttl' => 3600],
        ]);
        $return = $IB->fetch();
        if (!$return) {
            throw new Exception('IBlock with code"' . $code . '" not found');
        }

        return $return['ID'];
    }
}
