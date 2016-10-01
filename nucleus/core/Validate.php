<?php
class Validate{

	private $_passed = false,

			$_errors = array(),

			$_db = null;

	public function __construct(){

		$this->_db = DB::getInstance();

	}

	public function check($source, $items = array()){

		$name = "";

		foreach($items as $item => $rules){

			foreach($rules as $rule => $ruleValue){

				$value = trim($source[$item]);

				if($rule === 'title'){

					$name = $ruleValue;

				}

				if($rule === 'required' && empty($value)){

					$this->addError(["$item","$name is required"]);

				}else if(!empty($value)){

					switch($rule){

						case 'min' :

							if (strlen($value) < $ruleValue){

								$this->addError(["$item","$name must be a minimum of $ruleValue characters."]);

							}

						break;

						case 'max' :

							if (strlen($value) > $ruleValue){

								$this->addError(["$item","$name must be a maximum of $ruleValue characters."]);

							}

						break;

						case 'pattern' : 	// 'pattern' => array("%VECTOR%", "It should contain VEctor"),

							if (!preg_match($ruleValue[0], "$value")){

								$this->addError(["$item","$name is invalid - " . $ruleValue[1]]) ;

							}

						break;

						case 'matches' :

							if ($value != $source[$ruleValue]){

								$this->addError(["$item","$name must match."]);

							}

						break;

						case 'unique' :

							if(Input::get('thisID')){

								$check = $this->_db->get($ruleValue, '1', '[["'.$item.'", "=", "'.$value.'"], "AND", ["id", "!=", "'.Input::get('thisID').'"] ]');

							}else{

								$check = $this->_db->get($ruleValue, '1',  '[["'.$item.'", "=", "'.$value.'"]]');

							}


							if($check->count()){

								$this->addError(["$item","$name already exists."]);

							}


						break;

						case 'type' : 	// time url etc

							switch($ruleValue) {

						/* 		case 'email' :

									if (!preg_match('%{A-Za-z0-9._\$-}+@{A-Za-z0-9.-}+\.{A-Za-z}{2,4}%', "$value")){

										$this->addError(["$item","Invalid Email"]) ;

									}

								break;
								 */

								case 'number' :

									if (!preg_match('%\d{1,}%', "$value")){

										$this->addError(["$item","Invalid Nuber"]) ;

									}

									break;


							}

						break;

					}

				}

			}

		}

		if(empty($this->_errors)){

			$this->_passed = true;

		}

		return $this;

	}

	private function addError($error){

		$this->_errors[] = $error;

	}

	public static function hasError($errors,$field){

		foreach($errors as $temp){

			if ($temp[0] == $field){

				return true;

			}

		}

		return false;

	}

	public static function getError($errors,$field){

		foreach($errors as $temp){

			if ($temp[0] == $field){

				return $temp[1];

			}

		}

		return false;

	}

	public function errors(){

		return $this->_errors;

	}

	public function passed(){

		return $this->_passed;

	}

}
?>
