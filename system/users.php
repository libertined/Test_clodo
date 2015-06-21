<?php
global $classesRoot;
require_once($classesRoot.'/db/db.php');
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

    //Преобразуем полученный поля запроса в условия для SQL
    public function prepareFilter($fields){
        $filter = array();
        foreach($fields as $key => $value){
            $fields[$key] = trim($value);
        }
        if(!empty($fields["fio"]))
            $filter["NAME"] = "NAME LIKE '%".$fields["fio"]."%'";
        if(!empty($fields["phone"]))
            $filter["PHONE"] = "PHONE IS NOT NULL";
        //Баланс
        if(isset($fields["balance"]) && $fields["balance"] != ''){
            if(isset($fields["balance_marg"]) && $fields["balance_marg"] == 'more')
                $filter["BALANCE"] = "BALANCE > ".str_replace(",", ".", $fields["balance"]);
            else
                $filter["BALANCE"] = "BALANCE < ".str_replace(",", ".", $fields["balance"]);
        }
        //Дата
        if(!empty($fields["date_from"]) && !empty($fields["date_to"]))
            $filter["DATE_REG"] = "DATE_REG BETWEEN STR_TO_DATE('".date('Y-m-d H:i:s', strtotime($fields["date_from"]))."', '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE('".date('Y-m-d H:i:s', strtotime($fields["date_to"]))."', '%Y-%m-%d %H:%i:%s')";
        elseif(!empty($fields["date_from"]))
            $filter["DATE_REG"] = "DATE_REG >= STR_TO_DATE('".date('Y-m-d H:i:s', strtotime($fields["date_from"]))."', '%Y-%m-%d %H:%i:%s')";
        elseif(!empty($fields["date_to"]))
            $filter["DATE_REG"] = "DATE_REG <= STR_TO_DATE('".date('Y-m-d H:i:s', strtotime($fields["date_to"]))."', '%Y-%m-%d %H:%i:%s')";
        //Среднее значение платежа
        if(isset($fields["payment_from"]) && $fields["payment_from"] != '' &&  isset($fields["payment_to"]) && $fields["payment_to"] != '')
            $filter["PAYMENT"] = "AVG(AMOUNT) BETWEEN ".$fields["payment_from"]." AND ".$fields["payment_to"];
        elseif(isset($fields["payment_from"]) && $fields["payment_from"] != '')
            $filter["PAYMENT"] = "AVG(AMOUNT) >= ".$fields["payment_from"];
        elseif(isset($fields["payment_to"]) && $fields["payment_to"] != '')
            $filter["PAYMENT"] = "AVG(AMOUNT) ".$fields["payment_to"];

        return $filter;
    }

    //Получаем список пользователей по фильтру, с учетоб объединения таблиц
    public function getFilteredlist($fields){
        $fields = self::prepareFilter($fields);

        if(!isset($fields["PAYMENT"]))
            return self::getList($fields);
        else{
            $having = $fields["PAYMENT"];
            unset($fields["PAYMENT"]);
            $whereClose = '';
            if(!empty($fields)){
                $whereClose = "WHERE ".implode(" AND ", $fields)." ";
            }
            $DB = new DB();
            $sql = "SELECT * FROM users ".
                "LEFT JOIN payments ON users.ID = payments.USER_ID ".
                $whereClose.
                "GROUP BY payments.USER_ID ".
                "HAVING ".$having;

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

    //Получаем список пользователей
    public function getList($filter = ''){
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