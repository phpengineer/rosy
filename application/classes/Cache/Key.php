<?php

/**
 * 缓存key名称管理类
 *
 * @author pengmeng
 */
class Cache_Key {

	public static function videoInfo($videoId) {
		return 'video-info-' . $videoId;
	}

	public static function mainM3u8($videoId) {
		return 'mainM3u8-info-' . $videoId;
	}

	public static function subM3u8($videoId, $clarity) {
		return 'subM3u8-info-' . $clarity . '-' . $videoId;
	}

}
