<?php

namespace Sprint\Migration;

/**
 * Class HomeWork120210706173956
 * @package Sprint\Migration
 * Тип ИБ и ИБ 'Домашнее задание 1'
 */
class HomeWork120210706173956 extends Version
{
    /** @var string $description */
    protected $description = "Тип ИБ и ИБ 'Домашнее задание 1'";

    /** @var string $moduleVersion */
    protected $moduleVersion = "3.28.8";

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        /**
         * Тип ИБ
         */
        $helper->Iblock()->saveIblockType(array(
            'ID' => 'lesson1',
            'SECTIONS' => 'Y',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'IN_RSS' => 'N',
            'SORT' => '500',
            'LANG' =>
                array(
                    'ru' =>
                        array(
                            'NAME' => 'Лекция1',
                            'SECTION_NAME' => '',
                            'ELEMENT_NAME' => '',
                        ),
                    'en' =>
                        array(
                            'NAME' => 'Lesson1',
                            'SECTION_NAME' => '',
                            'ELEMENT_NAME' => '',
                        ),
                ),
        ));

        /**
         * ИБ
         */
        $iblockId = $helper->Iblock()->saveIblock(array(
            'IBLOCK_TYPE_ID' => 'lesson1',
            'LID' =>
                array(
                    0 => 's1',
                ),
            'CODE' => 'home_work',
            'API_CODE' => null,
            'NAME' => 'Домашнее задание',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'LIST_PAGE_URL' => '#SITE_DIR#/lesson1/index.php?ID=#IBLOCK_ID#',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/lesson1/detail.php?ID=#ELEMENT_ID#',
            'SECTION_PAGE_URL' => '#SITE_DIR#/lesson1/list.php?SECTION_ID=#SECTION_ID#',
            'CANONICAL_PAGE_URL' => '',
            'PICTURE' => null,
            'DESCRIPTION' => '',
            'DESCRIPTION_TYPE' => 'text',
            'RSS_TTL' => '24',
            'RSS_ACTIVE' => 'Y',
            'RSS_FILE_ACTIVE' => 'N',
            'RSS_FILE_LIMIT' => null,
            'RSS_FILE_DAYS' => null,
            'RSS_YANDEX_ACTIVE' => 'N',
            'XML_ID' => null,
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'Y',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'SECTION_CHOOSER' => 'L',
            'LIST_MODE' => '',
            'RIGHTS_MODE' => 'S',
            'SECTION_PROPERTY' => 'N',
            'PROPERTY_INDEX' => 'N',
            'VERSION' => '2', // Важно
            'LAST_CONV_ELEMENT' => '0',
            'SOCNET_GROUP_ID' => null,
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'SECTIONS_NAME' => 'Разделы',
            'SECTION_NAME' => 'Раздел',
            'ELEMENTS_NAME' => 'Элементы',
            'ELEMENT_NAME' => 'Элемент',
            'EXTERNAL_ID' => null,
            'LANG_DIR' => '/',
            'SERVER_NAME' => null,
            'ELEMENT_ADD' => 'Добавить элемент',
            'ELEMENT_EDIT' => 'Изменить элемент',
            'ELEMENT_DELETE' => 'Удалить элемент',
            'SECTION_ADD' => 'Добавить раздел',
            'SECTION_EDIT' => 'Изменить раздел',
            'SECTION_DELETE' => 'Удалить раздел',
        ));

        /**
         * Добавим свойства ИБ
         */
        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Просто строка',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'SIMPLE_STR',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'S',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'N',
            'XML_ID' => null,
            'FILE_TYPE' => '',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => '0',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '1',
            'USER_TYPE' => null,
            'USER_TYPE_SETTINGS' => null,
            'HINT' => '',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Просто число',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'SIMPLE_INT',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'N',
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'L',
            'MULTIPLE' => 'N',
            'XML_ID' => null,
            'FILE_TYPE' => '',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => '0',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '1',
            'USER_TYPE' => null,
            'USER_TYPE_SETTINGS' => null,
            'HINT' => '',
        ));

        $helper->Iblock()->saveProperty($iblockId, array(
            'NAME' => 'Нужно ли выводить строку?',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'CODE' => 'IS_SHOW',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'L', // Важно
            'ROW_COUNT' => '1',
            'COL_COUNT' => '30',
            'LIST_TYPE' => 'C', // Важно
            'MULTIPLE' => 'N',
            'XML_ID' => null,
            'FILE_TYPE' => '',
            'MULTIPLE_CNT' => '5',
            'LINK_IBLOCK_ID' => '0',
            'WITH_DESCRIPTION' => 'N',
            'SEARCHABLE' => 'N',
            'FILTRABLE' => 'N',
            'IS_REQUIRED' => 'N',
            'VERSION' => '1',
            'USER_TYPE' => null,
            'USER_TYPE_SETTINGS' => null,
            'HINT' => '',
            'VALUES' =>
                array(
                    0 =>
                        array(
                            'VALUE' => 'Да',
                            'DEF' => 'N',
                            'SORT' => '500',
                            'XML_ID' => 'yes',
                        ),
                ),
        ));

    }

    /**
     * @return bool|void
     * @throws Exceptions\HelperException
     */
    public function down()
    {
        $helper = $this->getHelperManager();

        $helper->Iblock()->deleteIblockIfExists('home_work');
        $helper->Iblock()->deleteIblockTypeIfExists('lesson1');
    }
}
