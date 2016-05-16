<?php
return array(
	'passport' => 'gvspassport',
	'lander' => 'database',
	'key' => ')&GY*^#<)(2O^#ME',
	'cipher' => MCRYPT_RIJNDAEL_128,
	'mode'   => MCRYPT_MODE_NOFB,
	
	'ldap' => array(
		'server' => '10.69.100.1',
		'port' => '389',
		'baseDN' => 'ou=美信,dc=meixin,dc=com', //DC (Domain Component) CN (Common Name) OU (Organizational Unit)
		'bindRDN' => '',
		'password' => '',
		'suffix' => '@gomeplus.com'
	),
		
	'database' => array(
		'group' => 'default',
	),
		
	'redis' => array(
		'server' => '127.0.0.1',
		'port' => '6379',
		'timeout' => 30,
		'persistent' => FALSE,
		'password' => 'foobared',
	),
);