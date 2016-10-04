<?php

namespace Nucleus\Core;

use Nucleus\Core\Neutron;
use Nucleus\Core\Redirect;
use Nucleus\Core\CoreExtension;

class App{

	protected $controller;

	protected $method;

	protected $params = [];

	public function __construct(){

		$this->controller = CoreExtension::get('route.default.controller');

		$this->method = CoreExtension::get('route.default.method');

		$url = Neutron::parseUrl();

		$url[0] = (isset($url[0])) ? $url[0] : $this->controller;

		if(file_exists( BASE_DIR . '/nucleus/controllers/_' . $url[0] . '.php')){

			$this->controller = ucfirst($url[0]);

			unset($url[0]);

		}

		$this->controller = "_" . $this->controller;

		$nameSpace = "Nucleus\Controllers\\" . $this->controller;

		$this->controller = new $nameSpace;

		if(isset($url[1])){

			if(method_exists($this->controller, $url[1])){

				$this->method = $url[1];

				unset($url[1]);

			}

		}

		if(!method_exists($this->controller, $this->method)){

				Redirect::to('');

		}

		$params = $url ? array_values($url) : [];

		foreach($params as $param){

			$this->params[] = Neutron::sanitize($param);

		}

		call_user_func_array([$this->controller, $this->method], $this->params);

	}



}

?>
