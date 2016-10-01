<?php

session_start();

define('NUCLEUS', BASE_DIR . '/nucleus');

require_once NUCLEUS . '/services/Config.php';

require_once NUCLEUS . '/services/Strings.php';

require_once NUCLEUS . '/services/CoreExtension.php';

require_once NUCLEUS . '/vendor/autoload.php';

require_once NUCLEUS . '/core/Quick.php';

spl_autoload_register(function($class) {

	if(file_exists(NUCLEUS . '/core/' . $class . '.php')){

		require_once NUCLEUS . '/core/' . $class . '.php';

	}else if(file_exists(NUCLEUS . '/classes/' . $class . '.php')){

		require_once NUCLEUS . '/classes/' . $class . '.php';

	}else if(file_exists(NUCLEUS . '/controllers/' . $class . '.php')){

		require_once NUCLEUS . '/controllers/' . $class . '.php';

	}else if(file_exists(NUCLEUS . '/model/' . $class . '.php')){

		require_once NUCLEUS . '/model/' . $class . '.php';

	}else if(file_exists(NUCLEUS . '/services/' . $class . '.php')){

		require_once NUCLEUS . '/services/' . $class . '.php';

	}

});
