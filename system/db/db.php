<?php
/**
 * DB - Класс для работы с базой данных
 * 
 * @param string $dbName
 * @param string $dbHost 
 * @param string $dbUser
 * @param string $dbPass
 */
require_once 'config_db.php';
class DB{
	protected $dbName = SQL_DATABASE;
	protected $dbHost = SQL_HOST;
	protected $dbUser = SQL_USER;
	protected $dbPass = SQL_PASSWORD; 
	protected $dbCon = '';
	protected $error = '';
	protected $count = 0;
	protected $result = array();
	
	/* Основной метод, создаем подключение к БД*/
	function DB(){
		$this->dbConn = ($dbConn=='')? mysql_connect($this->dbHost.':'.$this->dbPort, $this->dbUser, $this->dbPass):$dbConn;
	    if ( !$this->dbConn ){
			$this->error = mysql_error($this->dbConn);
			die();
		}
		if (!mysql_select_db($this->dbName, $this->dbConn)){
			$this->error = mysql_error($this->dbConn);
			die();
		}
		mysql_query('SET NAMES utf8');
	}
	
	/* Медот запроса (только селект)
	* Вернулось -1 - Ошибка
	* Вернулось 0 - Не найдено результатов
	* Вернулось >0 - Количество результатов
	*/
	function Query($sql){
	  $res = mysql_db_query($this->dbName, $sql, $this->dbConn);
	  if ( !$res ){
		  $this->error = mysql_error($this->dbConn);
		  return -1;
	  }
	  
	  $this->count = mysql_num_rows($res);
	  $this->result = array();

	  for($i = 0; $i < $this->count; $i++)
	  {
			  $row = mysql_fetch_assoc($res);              
			  $this->result[] = $row;
	  }

	  return $this->count; 
	}
	
	/* Медот запроса (в любой форме, кроме Select)
	* Вернулось -1 - Ошибка
	* Вернулось 0 - Не найдено результатов
	* Вернулось >0 - Количество результатов
	*/
	function QueryChange($sql){
	  $res = mysql_db_query($this->dbName, $sql, $this->dbConn);
	  if ( !$res ){
		  $this->error = mysql_error($this->dbConn);
		  return -1;
	  }
	  
	  $this->count = mysql_affected_rows();
	  $this->result = array();

	  return $this->count; 
	}
	
	/* Выводим Ошибку */
	function getError(){
		return $this->error;
	}
	
	/* Выводим Количество */
	function getCount(){
		return $this->count;
	}
	
	/* Выводи результат */
	function getResult(){
		return $this->result;
	}
}
 
?>