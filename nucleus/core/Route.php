<?php
class Route{

	public static function to($to){

		$to = str_replace('.','/',$to);

		$last = substr(Config::get('site.url'),strlen(Config::get('site.url')) - 1, strlen(Config::get('site.url')) ) ;

		$to = ($last == '/') ? $to : '/' . $to;

		return Config::get('site.url') . $to;

	}

}
?>
