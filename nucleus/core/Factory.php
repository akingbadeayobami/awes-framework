<?php
namespace Nucleus\Core;

trait Factory{

	protected  $_data = [], $_message = "";

	public function data(){

		return $this->_data;

	}

	public function message(){

		return $this->_message;

	}

}

?>
