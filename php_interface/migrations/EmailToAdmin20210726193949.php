<?php

namespace Sprint\Migration;


class EmailToAdmin20210726193949 extends Version
{
    protected $description = "Отправка данных на почту при добавлении элемента в ИБ";

    protected $moduleVersion = "3.28.8";

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();
        $helper->Event()->saveEventType('NEW_ELEMENT_ADDED', array (
  'LID' => 'ru',
  'EVENT_TYPE' => 'email',
  'NAME' => 'Добавлено новое событие',
  'DESCRIPTION' => '',
  'SORT' => '150',
));

            $helper->Event()->saveEventMessage('NEW_ELEMENT_ADDED', array (
  'LID' => 
  array (
    0 => 's1',
  ),
  'ACTIVE' => 'Y',
  'EMAIL_FROM' => '#DEFAULT_EMAIL_FROM#',
  'EMAIL_TO' => '#ADMIN_EMAIL#',
  'SUBJECT' => 'Добавление нового события',
  'MESSAGE' => 'Название:
#ADD_NAME#
Событие:
#ADD_EVENT#
Тема:
#ADD_THEME#
Автор:
#ADD_AUTHOR#',
  'BODY_TYPE' => 'text',
  'BCC' => '',
  'REPLY_TO' => '',
  'CC' => '',
  'IN_REPLY_TO' => '',
  'PRIORITY' => '',
  'FIELD1_NAME' => '',
  'FIELD1_VALUE' => '',
  'FIELD2_NAME' => '',
  'FIELD2_VALUE' => '',
  'SITE_TEMPLATE_ID' => '',
  'ADDITIONAL_FIELD' => 
  array (
  ),
  'LANGUAGE_ID' => '',
  'EVENT_TYPE' => '[ NEW_ELEMENT_ADDED ] Добавлено новое событие',
));
        }

    public function down()
    {
        //your code ...
    }
}
