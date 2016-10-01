<?php

class DB{

	private static $_instance = null;

	private $_cacheInstance = null;

	private static $_CACHEINSTANCEISSET = null;

	private $_pdo,
			$_query,
			$_error = false,
			$_cachedResults,
			$_count = 0;

	private function __construct(){

		try{

			$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));

		} catch (PDOException $e){

			die($e->getMessage());

		}

	}

	public static function getInstance(){

		if(!isset(self::$_instance)){

			self::$_instance = new DB();

		}

		return self::$_instance;
	}

	public function query($sql, $params = array()){

		echo $sql . "<br />";

		$this->_error = false;

		if($this->_query = $this->_pdo->prepare($sql)){

			$i = 1;

			if(count($params)){

				foreach($params as $param){

					$this->_query->bindValue($i, $param);

					$i++;

				}

			}

			if(!$this->_query->execute()){

				print_r($this->_query->errorInfo());

				$this->_error = true;

			}

		}

		return $this;

	}

	public function results(){

		return $this->_query->fetchAll(PDO::FETCH_OBJ);

	}

	public function error(){

		return $this->_error;

	}

}

?>
