<?php
trait ClassInterface{

	protected  $_data = [], $_message = "";

	public function data(){

		return $this->_data;

	}

	public function message(){

		return $this->_message;

	}

	public function validations(){

		return (object) $this->_validations;

	}

}

?>
