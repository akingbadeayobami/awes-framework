<?php

namespace Nucleus\Core;

class Route{

	public static function to($to){

		$to = str_replace('.','/',$to);

		$last = substr(cg('site.url'),strlen(cg('site.url')) - 1, strlen(cg('site.url')) ) ;

		$to = ($last == '/') ? $to : '/' . $to;

		return cg('site.url') . $to;

	}

}
?>
