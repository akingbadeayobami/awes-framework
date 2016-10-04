<?php
namespace Nucleus;

session_start();

define('NUCLEUS', BASE_DIR . '/nucleus');

require_once NUCLEUS . '/services/Config.php';

require_once NUCLEUS . '/services/Strings.php';

require_once NUCLEUS . '/services/CoreExtension.php';

require_once NUCLEUS . '/vendor/autoload.php';

require_once NUCLEUS . '/core/Quick.php';

spl_autoload_register(function($autoloadClass) {

	$class = explode('\\',$autoloadClass);

	if($class[0] == 'Nucleus'){

		unset($class[0]);

		$directory = strtolower($class[1]);

		unset($class[1]);

		$file = implode('/',$class);

		require_once NUCLEUS . '/' . $directory . '/' . $file . '.php';

	}
	
});
