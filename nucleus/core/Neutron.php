<?php
class Neutron{

	public static function sanitize ($string){

		return htmlentities($string, ENT_QUOTES, 'UTF-8');

	}

	public static function unSanitize ($string){

		return html_entity_decode($string, ENT_QUOTES, 'UTF-8');

	}

	public static function arraylize($stringOrArray){

		return (is_string($stringOrArray)) ? explode(",",$stringOrArray) : $stringOrArray;

	}

	public static function stringify($stringOrArray){

		return (is_string($stringOrArray)) ? $stringOrArray : implode(",",$stringOrArray);

	}

	public static function parseUrl(){

		if(isset($_GET['url'])){

			$url = explode( '/', filter_var(rtrim($_GET['url'], '/')));

			return $url;

		}

		return '';

	}

	public static function logUrl(){

		if(!in_array($url[0],['notification','adverts','features'])){

			if(!in_array($_GET['url'],['user/check','course/my'])){

				$appOrWeb = (isset($_GET['jsoncallback'])) ? ':app' : ':web';

				Analytics::sLog(Input::get('url').$appOrWeb);

			}

		}

	}

	public static function randomChar($length){

		$return = '';

		$alphaNumeric = array_merge(range(0, 9), range('a', 'z'));

		for ($i = 0; $i < $length; $i++) {

			$return .= $alphaNumeric[array_rand($alphaNumeric)];

		}

		return $return;

	}

	public static function getFromField($fields,$xAble){

		$return = Array();

		foreach($fields as $item => $rules){

			foreach($rules as $rule => $ruleValue){

				if($rule === $xAble && $ruleValue == true ){

					$return[] = $item;

					break;

				}

			}

		}

		return $return;

	}

	public static function fieldHasColumn($field, $column){

		foreach($field as $item => $rules){

			if($item == $column){

				return true;

			}

		}

		return false;

	}

	public static function getFromFieldThisThat($fields,$this,$that){

		$return = Array();

		foreach($fields as $item => $rules){

			foreach($rules as $rule => $ruleValue){

				if($rule === $this && $ruleValue == $that ){

					$return[] = $item;

					break;

				}

			}

		}

		return $return;

	}

}

?>
