<?php
class CoreExtension {

	public static function get($path = null){

		if($path){

			$coreextension = $GLOBALS['coreextension'];

	    $path = str_replace('.','/',$path);

			$path = explode('/', $path);

			foreach($path as $bit){

				if(isset($coreextension[$bit])){

					$coreextension = $coreextension[$bit];

				}

			}

			return $coreextension;

		}

		return false;

	}



}


?>
