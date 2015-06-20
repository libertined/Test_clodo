<?php
/* Users - Класс для работы с пользователями
*/
$classesRoot = $_SERVER["DOCUMENT_ROOT"].'/system';
class Users{
    protected $id;	//id
    protected $name; // ФИО пользователя
    protected $email; // Email пользователя
    protected $phone; // Телефон пользователя
    protected $balance; //Баланс пользователя
    protected $date_reg; // Дата регистрации

    // Создаём/пересоздаем таблицу
    public function createTable() {
        $err_mess = "<br>Function: Users::createTable<br>Line: ";
        global $DB;
        $DDL = 'DROP TABLE IF EXISTS users;';
        $DDL2 = 'CREATE TABLE users ('.
            'ID INT(11) NOT NULL AUTO_INCREMENT,'.
            'NAME VARCHAR(30),'.
            'EMAIL VARCHAR(30) NOT NULL,'.
            'PHONE VARCHAR(15),'.
            'BALANCE DECIMAL (12,2),'.
            'DATE_REG DATETIME,'.
            'primary key (ID)'.
            ');';

        $DB->Query($DDL, false, $err_mess.__LINE__);
        $DB->Query($DDL2, false, $err_mess.__LINE__);
    }


}