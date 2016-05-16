<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'default' => array
	(
		'type'       => 'PDO',
		'connection' => array(
				'dsn'        => 'mysql:host=atlas01.dev.gomeplus.com;port=8806;dbname=video_account;charset=utf8',
				'username'   => 'develop',
				'password'   => 'ZQ2yGUJfE2',
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
				'dsn'        => 'mysql:host=atlas01.dev.gomeplus.com;port=8806;dbname=video_account;charset=utf8',
				'username'   => 'develop',
				'password'   => 'ZQ2yGUJfE2',
				'persistent' => FALSE,
		),
		'table_prefix' => 'gvs_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
	//视频
	'video' => array
	(
		'type'       => 'PDO',
		'connection' => array(
				'dsn'        => 'mysql:host=atlas01.dev.gomeplus.com;port=8806;dbname=video_base;charset=utf8',
				'username'   => 'develop',
				'password'   => 'ZQ2yGUJfE2',
				'persistent' => FALSE,
		),
		'table_prefix' => 'gvs_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
	//订阅
	'sub' => array
	(
		'type'       => 'MySQL',
		'connection' => array(
			'hostname'   => 'localhost',
			'database'   => 'video_sub',
			'username'   => 'root',
			'password'   => 'root',
			'persistent' => FALSE,
		),
		'table_prefix' => 'sub_',
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
	//杂项
	'misc' => array
	(
		'type'       => 'PDO',
		'connection' => array(
				'dsn'        => 'mysql:host=atlas01.dev.gomeplus.com;port=8806;dbname=video_misc;charset=utf8',
				'username'   => 'develop',
				'password'   => 'ZQ2yGUJfE2',
				'persistent' => FALSE,
		),
		'table_prefix' => 'misc_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
);