<?php
namespace Nucleus\Core;

use Nucleus\Core\DB;
use Nucleus\Core\CoreExtension;

class Validate{

	private $_passed = false,

			$_errors = array(),

			$_db = null;

	public function __construct(){

		$this->_db = DB::getInstance();

	}

	public function check($source, $items = array()){

		foreach($items as $item => $rules){

			$name = ucfirst($item);

			$rules = explode("|",$rules);

			foreach($rules as $eachRule){

				$eachRule = explode(':',$eachRule);

				$rule = $eachRule[0];

				$ruleValue = (isset($eachRule[1])) ? $eachRule[1] : "";

				$value = trim($source[$item]);

				if($rule === 'title'){

					$name = $ruleValue;

				}

				if($rule === 'required' && empty($value)){

					$this->addError(["$item","$name is required"]);

					continue;

				}

				if(in_array($rule,array_keys(CoreExtension::get('validation.input_fields')))){

					$input_field = CoreExtension::get('validation.input_fields');

					$validation = $input_field[$rule];

					if(!empty($validation)){

						if (!preg_match("%$validation%", $value)){

							$this->addError(["$item","Invalid $name"]) ;

						}

					}

					continue;

				}

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

					case 'pattern' :

						if (!preg_match("%" . $ruleValue . "%", "$value")){

							$desc = (isset($eachRule[2])) ? "- " . $eachRule[2] : "" ;

							$this->addError(["$item","$name is invalid $desc"]) ;

						}

					break;

					case 'matches' :

						if ($value != $source[$ruleValue]){

							$otherField = (isset($eachRule[2])) ? $eachRule[2] : $ruleValue ;

							$this->addError(["$item","$name must match " . $otherField]);

						}

					break;

					case 'unique' :

						if(Model::table($ruleValue)->where($item,$value)->count() == 1){

							$this->addError(["$item","$name has already been taken."]);

						}

					break;

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


	public function errors(){

		return $this->_errors;

	}

	public function passed(){

		return $this->_passed;

	}

}
?>
