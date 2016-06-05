<?php

/**
 * 缓存key名称管理类
 *
 */
class Cache_Key {

	public static function vcode($mobile) {
		return 'vcode-' . $mobile;
	}

}
