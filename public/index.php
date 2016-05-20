<?php
if (!isset($_SERVER['ENVIRONMENT'])) {
	$_SERVER['ENVIRONMENT'] = 'DEVELOPMENT';
}
switch (strtoupper($_SERVER['ENVIRONMENT'])) {
	case 'DEVELOPMENT':
		$path = '../';
		break;
	case 'PRODUCTION':
		$path = '../';
		break;
	case 'STAGING':
		$path = '../';
		break;
	case 'TESTING':
		$path = '../';
		break;
}
$application = '../application';
$modules = $path . 'kohana/modules';
$system = $path . 'kohana/system';
$business = '../application/classes/Business';

define('EXT', '.php');

error_reporting(E_ALL | E_STRICT);

define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('APPPATH', realpath($application).DIRECTORY_SEPARATOR);
define('MODPATH', realpath($modules).DIRECTORY_SEPARATOR);
define('SYSPATH', realpath($system).DIRECTORY_SEPARATOR);
define('BIZPATH', realpath($business).DIRECTORY_SEPARATOR);

define('APPNAME', 'gvs');
define('PORTAL', basename(__FILE__));
define('MODULEDIR', '/');
define('CACHEDIR', realpath($application.'/cache').DIRECTORY_SEPARATOR);
define('LOGDIR', realpath($application.'/logs').DIRECTORY_SEPARATOR);


$defaultController = 'index';
$defaultAction = 'index';

unset($application, $modules, $system, $business);

if ( ! defined('KOHANA_START_TIME')) {
	define('KOHANA_START_TIME', microtime(TRUE));
}

if ( ! defined('KOHANA_START_MEMORY')) {
	define('KOHANA_START_MEMORY', memory_get_usage());
}

// Bootstrap the application
require APPPATH.'bootstrap'.EXT;

if (PHP_SAPI == 'cli') {
	class_exists('Minion_Task') OR die('Please enable the Minion module for CLI support.');
	set_exception_handler(array('Minion_Exception', 'handler'));
	Minion_Task::factory(Minion_CLI::options())->execute();
} else {
	/**
	 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
	 * If no source is specified, the URI will be automatically detected.
	 */
	echo Request::factory(TRUE, array(), FALSE)
		->execute()
		->send_headers(TRUE)
		->body();
}
