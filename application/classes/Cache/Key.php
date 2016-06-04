<?php

/**
 * 缓存key名称管理类
 *
 * @author pengmeng
 */
class Cache_Key {

	public static function vcode($mobile) {
		return 'vcode-' . $mobile;
	}

}
