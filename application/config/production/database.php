<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'default' => array
	(
		'type'       => 'MySQL',
		'connection' => array(
			'hostname'   => 'localhost',
			'database'   => 'video_account',
			'username'   => 'root',
			'password'   => 'root',
			'persistent' => FALSE,
		),
		'table_prefix' => 'gvs_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
	//账号
	'account' => array
	(
		'type'       => 'MySQL',
		'connection' => array(
			'hostname'   => 'localhost',
			'database'   => 'video_account',
			'username'   => 'root',
			'password'   => 'root',
			'persistent' => FALSE,
		),
		'table_prefix' => 'gvs_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
	//视频
	'video' => array
	(
		'type'       => 'MySQL',
		'connection' => array(
			'hostname'   => 'localhost',
			'database'   => 'video_base',
			'username'   => 'root',
			'password'   => 'root',
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
	//杂项
	'misc' => array
	(
		'type'       => 'MySQL',
		'connection' => array(
			'hostname'   => 'localhost',
			'database'   => 'video_misc',
			'username'   => 'root',
			'password'   => 'root',
			'persistent' => FALSE,
		),
		'table_prefix' => 'misc_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
	),
);
