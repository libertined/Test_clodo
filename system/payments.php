<?php
/* Payments - Класс для работы с пользователями
*/
$classesRoot = $_SERVER["DOCUMENT_ROOT"].'/system';
class Payments{
    protected $id;	//id
    protected $date_pay; // Дата платежа
    protected $amount; // Сумма платежа

    // Создаём/пересоздаем таблицу
    public function createTable() {
        $err_mess = "<br>Function: Payments::createTable<br>Line: ";
        global $DB;
        $DDL = 'DROP TABLE IF EXISTS payments;';
        $DDL2 = 'CREATE TABLE payments ('.
            'ID INT(11) NOT NULL AUTO_INCREMENT,'.
            'DATE_AYP DATETIME,'.
            'AMOUNT DECIMAL (12,2),'.
            'primary key (ID)'.
            ');';

        $DB->Query($DDL, false, $err_mess.__LINE__);
        $DB->Query($DDL2, false, $err_mess.__LINE__);
    }


}