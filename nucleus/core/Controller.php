<?php

	class Controller {

		// private $errors = [];

		public function view($view, $data=[]){

			return new View($view, $data);

		}

		public function renderHeader($data=[]){

			$data = array_merge($data, $this->appController());

			$data = (object) $data;

			require_once('../partials/template/header.php');

		}

		public function factory($model, $method, $params=[]){

			$model = new $model();

			foreach($params as $key => $value){

				$_GET[$key] = $value;

			}

			$status = call_user_func_array([$model, $method],$params) || false;

			return (object)['data' =>  $model->data() , 'status' => $status, 'message' => $model->message() ];

		}

		public function action($submitButton, $model, $method, $params=[]){

			if(Input::exists() && !empty($_POST)){

				if(Input::has($submitButton)){

					if(Token::check(Input::get(Config::get('session.token_name')))){

						$model = new $model();

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

						foreach($params as $key => $value){

							$_GET[$key] = $value;

						}

						$status = call_user_func_array([$model, $method], $params) || false;

						$message = $model->message();

						if(isset($message) && strlen($message) > 0){

							if($status){

								Session::flash('success', $message);

							}else{

								Session::flash('error', $message);

							}

						}

						return (object)['data' =>  $model->data() , 'status' => $status];

					}

				}

			}

		}

		public function middleWare($function, $params = []){

			return call_user_func_array(['Middleware', $function], $params);

		}

	}

?>
