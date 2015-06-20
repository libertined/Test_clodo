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
        $DB = new DB();
        $DDL = 'DROP TABLE IF EXISTS users;';
        $DDL2 = 'CREATE TABLE users ('.
            'ID INT(11) NOT NULL AUTO_INCREMENT,'.
            'NAME VARCHAR(30),'.
            'EMAIL VARCHAR(30) NOT NULL,'.
            'PHONE VARCHAR(25),'.
            'BALANCE DECIMAL (12,2),'.
            'DATE_REG DATETIME,'.
            'primary key (ID)'.
            ')';

        $DB->Query($DDL);
        $DB->Query($DDL2);
    }

    //конструктор
    public function __construct(){
        $this->id = 0;
        $this->name = "";
        $this->email = "";
        $this->phone = "";
        $this->balance = 0;
        $this->date_reg = date("d.m.Y H:i:s");
    }

    //Получаем текущего пользователя в виде массива
    public function getUserArr(){
        $tmpUser = array(
            "ID" => $this->id,
            "NAME" => $this->name,
            "EMAIL" => $this->email,
            "PHONE" => $this->phone,
            "BALANCE" => $this->balance,
            "DATE" => $this->date_reg,
        );
        return $tmpUser;
    }

    //Получаем пользователя (преобразуем из массива или текущего)
    public function getUser($fields = array()){
        if(empty($fields)){
            return self::getUserArr();
        }
        $tmpUser = $fields;
        if(!isset($fields["ID"])){
            $tmpUser["ID"] = 0;
        }
        return $tmpUser;
    }

    //Получаем список пользователей
    public function getList($filter = ''){
        global $classesRoot;
        require_once($classesRoot.'/db/db.php');

        $DB = new DB();
        $whereClose = "";

        if(!empty($filter)){
            $whereClose = "WHERE ".implode(" AND ", $filter);
        }

        $sql = "SELECT * FROM users ".$whereClose;
        $res = $DB->Query($sql);
        if($res < 0){
            echo $DB->getError();
        }
        elseif($res == 0)
        {
            return array();
        }
        else{
            $countRes = $DB->getCount();
            $itemsList = array();
            $resultCont = $DB->getResult();

            for($i=0; $i<$countRes; $i++){
                $itemsList[$i] = self::getUser($resultCont[$i]);
            }
            return $itemsList;
        }
    }

}