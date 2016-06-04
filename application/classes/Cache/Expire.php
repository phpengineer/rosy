<?php

/**
 * 缓存时间管理类
 *
 * @author pengmeng
 */
class Cache_Expire {

	/**
	 * vcode缓存时间
	 * @return type
	 */
	public static function vcode() {
		return (int) Kohana::$config->load('expire.vcode');
	}

}
