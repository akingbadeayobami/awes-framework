<?php

class App{

	protected $controller = 'home';

	protected $method = 'index';

	protected $params = [];


	public function __construct(){

		$url = Neutron::parseUrl();

		$url[0] = (isset($url[0])) ? $url[0] : $this->controller;

		if(file_exists( BASE_DIR . '/nucleus/controllers/_' . $url[0] . '.php')){

			$this->controller = ucfirst($url[0]);

			unset($url[0]);

		}

		$this->controller = "_" . $this->controller;

		$this->controller = new $this->controller;

		if(isset($url[1])){

			if(method_exists($this->controller, $url[1])){

				$this->method = $url[1];

				unset($url[1]);

			}

		}

		if(!method_exists($this->controller, $this->method)){

				Redirect::to(Route::to(''));

		}

		$params = $url ? array_values($url) : [];

		foreach($params as $param){

			$this->params[] = Neutron::sanitize($param);

		}

		call_user_func_array([$this->controller, $this->method], $this->params);

	}



}

?>
