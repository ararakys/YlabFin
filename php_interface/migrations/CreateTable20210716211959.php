<?php

namespace Sprint\Migration;


class CreateTable20210716211959 extends Version
{
    protected $description = "Миграция таблицы";

    protected $moduleVersion = "3.28.8";

    public function up()
    {
        try{
        $connection = \Bitrix\Main\Application::getConnection();
        $connection->query("
		    	CREATE TABLE IF NOT EXISTS `y_profiles`(
                    `ID` int(11) NOT NULL AUTO_INCREMENT,
                    `NAME` varchar(255) NOT NULL,
                    `URL` varchar (255) NOT NULL,
                    PRIMARY KEY(`ID`))
                    ENGINE = InnoDB default CHARSET = utf8 COLLATE = utf8_unicode_ci
                ");
    } catch(\Bitrix\Main\DB\SqlException $e){
        $this->outError("Ошибка: ".$e->getMessage());
        return false;
    }
	    $this->outSuccess('Таблица установлена');
	    return;
    }

    public function down()
    {
        try{
            $connection = \Bitrix\Main\Application::getConnection();
            $connection->dropTable('y_profiles');
        } catch(\Bitrix\Main\DB\SqlException $e){
            $this->outError("Ошибка: ".$e->getMessage());
            return false;
        }
        $this->outSuccess('Таблица удалена');
        return;

    }

}
