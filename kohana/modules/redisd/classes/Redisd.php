<?php

/**
 * reids缓存操作类
 * @author pengmeng<pengmeng@gomeplus.com>
 */
class Redisd {

	protected static $_instance = NULL;
	protected static $_instanceSelf = null;

	/*
	 * @return Redisd
	 */

	public static function instance($type) {
		if (self::$_instanceSelf === NULL) {
			self::$_instanceSelf = new Redisd($type);
		}
		return self::$_instanceSelf;
	}

	public function __construct($type) {
		$servers = Kohana::$config->load('redisd.' . $type);
		if (empty($servers)) {
			throw new Exception('redisd config group [ ' . $type . ' ] not found');
		}
		if (self::$_instance === NULL) {
			$server = $servers[array_rand($servers)];
			$redis = new Redis();
			if ($server['persistent']) {
				$redis->pconnect($server['host'], $server['port'], $server['timeout']);
			} else {

				$redis->connect($server['host'], $server['port'], $server['timeout']);
			}

			if ($server['password'] !== NULL) {
				$password = $server['password'];
				$result = $redis->auth($password);
				if (strtolower($result) != true) {
					throw new Exception("Invaild redis [ " . $type . " ] password: {$password}");
				}
			}
			self::$_instance = $redis;
		}
	}

	public function get($key) {
		$data = self::$_instance->get($key);
		return @unserialize($data);
	}

	public function delete($key) {
		return self::$_instance->delete($key);
	}

	public function set($key, $value, $expire = 0) {
		$value = @serialize($value);
		if ($expire) {
			return self::$_instance->setex($key, $expire, $value);
		} else {
			return self::$_instance->set($key, $value);
		}
	}

}
