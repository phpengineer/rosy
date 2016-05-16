<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'default' => array
	(
		'type'       => 'PDO',
		'connection' => array(
				'dsn'        => 'mysql:host=10.125.2.9;port=3306;dbname=video_account;charset=utf8',
				'username'   => 'gome_videoact',
				'password'   => 'EC85E5Ade5v',
				'persistent' => FALSE,
		),
		'table_prefix' => 'gvs_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
	//账号
	'account' => array
	(
		'type'       => 'PDO',
		'connection' => array(
				'dsn'        => 'mysql:host=10.125.2.9;port=3306;dbname=video_account;charset=utf8',
				'username'   => 'gome_videoact',
				'password'   => 'EC85E5Ade5v',
				'persistent' => FALSE,
		),
		'table_prefix' => 'gvs_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
	//视频
	//视频
	'video' => array
	(
		'type'       => 'PDO',
		'connection' => array(
				'dsn'        => 'mysql:host=10.125.2.9;port=3306;dbname=video_base;charset=utf8',
				'username'   => 'gome_videoact',
				'password'   => 'EC85E5Ade5v',
				'persistent' => FALSE,
		),
		'table_prefix' => 'gvs_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
	
	//直播
	'live' => array
	(
		'type'       => 'MySQL',
		'connection' => array(
			'hostname'   => 'localhost',
			'database'   => 'video_live',
			'username'   => 'root',
			'password'   => 'root',
			'persistent' => FALSE,
		),
		'table_prefix' => 'live_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
);