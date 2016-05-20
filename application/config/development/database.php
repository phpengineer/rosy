<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'default' => array
	(
		'type'       => 'PDO',
		'connection' => array(
				'dsn'        => 'mysql:host=139.129.164.156;port=3306;dbname=hxoneshop;charset=utf8',
				'username'   => 'root',
				'password'   => 'qwert12345',
				'persistent' => FALSE,
		),
		'table_prefix' => 'hx_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
);
