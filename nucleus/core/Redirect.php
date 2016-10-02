<?php

namespace Nucleus\Core;

class Redirect{

	public static function to($location = null){

			if(is_numeric($location)){

				switch($location){

					case 404:

						header('HTTP/1.0 404 Not Found');

						include 'errors/404.php';

						exit();

					break;

					case 500:

						header('HTTP/1.0 500 System Error');

						include 'errors/500.php';

						exit();

					break;

				}

			}

			if(substr($location,0,4) != 'http'){

				$location = Route::to($location);

			}

			header('Location: ' . $location);

			exit();

	}

}

?>
