<?php

namespace Nucleus\Core;

class Input {

	public static function exists (){

		if (!empty($_REQUEST)) {

			return true;

		}

		return false;

	}

	public static function get($item){

		if(isset($_REQUEST[$item])){

			return Neutron::sanitize($_REQUEST[$item]);

		}

		return false;

	}

	public static function has($item){

		if(isset($_REQUEST[$item])){

			return true;

		}

		return false;


	}

	public static function all(){

		if(isset($_REQUEST)){

			return array_map(function($each){

					return Neutron::sanitize($each);

			},$_REQUEST);

		}

		return $_REQUEST;

	}

	public static function only($field){

		$field = Neutron::arraylize($field);

		$return = [];

		foreach($field as $index){

			$return[$index] = self::get($index);

		}

		return $return;

	}

}








?>
