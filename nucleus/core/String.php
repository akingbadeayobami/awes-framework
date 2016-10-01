<?php
class String {

	public static function get($path = null){

		if($path){

			$string = $GLOBALS['string'][Config::get('site.lang')];

	    $path = str_replace('.','/',$path);

			$path = explode('/', $path);

			foreach($path as $bit){

				if(isset($string[$bit])){

					$string = $string[$bit];

				}

			}

			return $string;

		}

		return false;

	}



}


?>
