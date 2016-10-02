<?php
namespace Nucleus\Core;

class Config {

	public static function get($path = null){

		if($path){

			$config = $GLOBALS['config'];

	    $path = str_replace('.','/',$path);

			$path = explode('/', $path);

			foreach($path as $bit){

				if(isset($config[$bit])){

					$config = $config[$bit];

				}

			}

			return $config;

		}

		return false;

	}



}


?>
