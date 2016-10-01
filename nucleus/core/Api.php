<?php

class API{

	protected $model, $method,  $validation = [], $params = [];

	public function __construct(){

		$url = Neutron::parseUrl();

		$User = new User();

		if(!$User->isLoggedIn() && $url[1] != "logout"  && $url[1] != "login" && $url[1] != "register" && $url[1] != "recoverpassword"){

			$return['status'] = false;

			$return['data'] = 'invalidLogin';

			$return['message'] = "Authentication Is Wrong";

		}else {

			if(!file_exists(   $_SERVER['DOCUMENT_ROOT'] . '/nucleus/classes/' . ucfirst($url[0]) . '.php')){

				$return['status'] = false;

				$return['data'] = 'invalidModel';

				$return['message'] = "Invalid Model";

			}else{

				$this->model = $url[0];

				unset($url[0]);

				$this->model = new $this->model;

				if(!isset($url[1])){

					$return['status'] = false;

					$return['data'] = 'methodNotDeclared';

					$return['message'] = "Method Not Declared";

				}elseif( !method_exists($this->model, $url[1])){

					$return['status'] = false;

					$return['data'] = 'invalidMethod';

					$return['message'] = "Invalid Method";

				}else{

					$method = $this->method = $url[1];

					unset($url[1]);

					$params = $_GET ? array_values($_GET) : [];

					foreach($params as $temp){

						$this->params[] = Neutron::sanitize($temp);

					}

					$this->validation = (isset($this->model->validations()->$method)) ? $this->model->validations()->$method : [];

					$validationKeys = array_keys($this->validation);

					$count = 0;

					$validationParameters = [];

					foreach($this->validation as $temp){

						$validationParameters[$validationKeys[$count]] = (isset($params[$count])) ? Neutron::sanitize($params[$count]) : "";

						$count++;

					}

					$Validate = new Validate();

					$Validate->check($validationParameters, $this->validation);

					   if(false){// if(!$Validate->passed()){

						$return['status'] = false;

						$return['data'] = $Validate->errors();

						$return['message'] = $Validate->errors()[0][1];

					}else {

						$return['status'] = call_user_func_array([$this->model, $this->method], $this->params) || false;

						$return['data'] = $this->model->data();

						$return['message'] = $this->model->message();

					}

				}

			}

		}

		$return = Neutron::unSanitize(json_encode($return));

		if(isset($_REQUEST['jsoncallback'])){

			echo $_REQUEST['jsoncallback'] . '(' . $return  . ')';

		} else {

			echo $return;

		}

	}

}
?>
