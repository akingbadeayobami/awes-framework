<?php

	namespace Nucleus\Core;

	use Nucleus\Core\View;
	use Nucleus\Services\Middleware;
	use Nucleus\Core\Validate;

	class Controller {

		public function view($view, $data=[]){

			return new View($view, $data);

		}

		public function renderHeader($data=[]){

			$data = array_merge($data, $this->appController());

			$data = (object) $data;

			require_once('../partials/template/header.php');

		}

		public function factory($factory, $method, $params=[], $closure = false){

			$factory = "__" . $factory;

			$nameSpace = "Nucleus\Factories\\" . $factory;

			$factory = new $nameSpace;

			foreach($params as $key => $value){

				$_GET[$key] = $value;

			}

			$status = call_user_func_array([$factory, $method],$params) || false;

			$message = $factory->message();

			if(isset($message) && strlen($message) > 0){

				if($status){

					Session::flash('success', $message);

				}else{

					Session::flash('error', $message);

				}

			}

			if($closure){

				return $closure((object)['data' =>  $factory->data() , 'status' => $status]);

			}

			return (object)['data' =>  $factory->data() , 'status' => $status, 'message' => $factory->message() ];

		}

		public function action($submitButton, $model, $method, $params=[],$closure = false ){

			if(Input::exists() && !empty($_REQUEST)){

				if(Input::has($submitButton)){

					if(Token::check(Input::get(Config::get('session.token_name')))){

						$factory = $model;

						$nameSpace = "Nucleus\Model\\" . $model;

						$model = new $nameSpace;

						$validate = new Validate();

						$validation = [];

						foreach(Input::all() as $key => $field){

							if(isset($model->validations()->$key)){

								$validation[$key] = $model->validations()->$key;

							}

						}

						$validate->check(Input::all() , $validation);

						if(!$validate->passed()){

							$GLOBALS['errors'] = $validate->errors() ;

							return false;

						}

						$return = $this->factory($factory,$method,$params,$closure);

						Token::delete();

						return $return;

					}

				}

			}

		}

		public function middleWare($function, $params = []){

			return call_user_func_array(['Middleware', $function], $params);

		}

	}

?>
