<?php

/**
 * 缓存时间管理类
 *
 * @author pengmeng
 */
class Cache_Expire {

	/**
	 * 视频播放信息缓存时间
	 * @return type
	 */
	public static function videoInfo() {
		return (int) Kohana::$config->load('expire.videoInfo');
	}

	/**
	 * 视频一级m3u8信息缓存时间
	 * @return type
	 */
	public static function mainM3u8() {
		return (int) Kohana::$config->load('expire.mainM3u8');
	}

	/**
	 * 视频二级m3u8信息缓存时间
	 * @return type
	 */
	public static function subM3u8() {
		return (int) Kohana::$config->load('expire.subM3u8');
	}

}
