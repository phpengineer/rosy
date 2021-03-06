<?php

class Misc {

	static public function encrypt($text, $key = '') {
		$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB);
		$ciphertext = trim(Misc::base64url_encode($ciphertext));
		return $ciphertext;
	}

	static public function decrypt($text, $key = '') {
		$ciphertext = Misc::base64url_decode($text);
		$cleartext = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $ciphertext, MCRYPT_MODE_ECB));
		return $cleartext;
	}

	static function base64url_encode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	static function base64url_decode($data) {
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	}

	static public function message($message, $redirect = NULL, $delay = 3) {
		echo View::factory('misc/message')
			->set('message', $message)
			->set('redirect', $redirect)
			->set('delay', $delay);
		exit();
	}

	static public function warning($message) {
		echo View::factory('misc/warning')
			->set('message', $message);
		exit();
	}

	static public function toUTF8($string = array(), $fromEncoding = 'GBK') {
		if (is_array($string)) {
			foreach ($string as &$value) {
				self::toUTF8($value);
			}
		} else {
			$string = mb_convert_encoding($string, 'UTF8', $fromEncoding);
		}

		return $string;
	}

	/**
	 * 汉字转拼音
	 * @param string $word
	 * @return string
	 */
	static public function pinyin($word = '') {

		$length = strlen($word);
		if ($length < 3) {
			return $word;
		}

		static $dictionary = array();
		if (!$dictionary) {
			$dictionary = Kohana::$config->load('pinyin')->as_array();
		}

		$pinyins = array();
		$nonchinese = '';
		for ($i = 0; $i < $length; $i++) {
			$ascii = ord($word[$i]);
			if ($ascii < 128) {
				if ($ascii >= 65 && $ascii <= 90) {
					$nonchinese .= strtolower($word[$i]);
				} else {
					$nonchinese .= $word[$i];
				}
			} else {
				if ($nonchinese) {
					$pinyins[] = $nonchinese;
					$nonchinese = '';
				}
				$character = $word[$i];
				$character .= isset($word[++$i]) ? $word[$i] : '';
				$character .= isset($word[++$i]) ? $word[$i] : '';
				$pinyins[] = isset($dictionary[$character]) ? $dictionary[$character] : '';
			}
		}
		if ($nonchinese) {
			$pinyins[] = $nonchinese;
			$nonchinese = '';
		}
		return implode(' ', $pinyins);
	}

	/**
	 * 
	 * 获取微博用户信息
	 * @param integer $source  appkey
	 * @param integer $userId  用户id
	 * @return array
	 */
	static public function getWeiboUser($source, $userId) {
		$userId = $userId + 0;
		if (!$source || !$userId) {
			return FALSE;
		}
		$url = "http://i2.api.weibo.com/2/users/show.json";
		$postUrl = $url . "?source=" . $source . "&uid=" . $userId;

		// 设置curl请求,后续封装方法
		$ch = curl_init();
		// 设置选项
		curl_setopt($ch, CURLOPT_URL, $postUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		// 执行内容
		$result = curl_exec($ch);
		// 释放curl句柄
		curl_close($ch);

		$result = json_decode($result, TRUE);
		return $result;
	}

	//获取客户端IP
	static public function getClientIp() {
		$ip = 0;
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
			$forwarded = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$ip = array_shift($forwarded);
		} else if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP']) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			if (!empty($_SERVER['REMOTE_ADDR'])) {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
		}
		return $ip;
	}

	/** 美化Json数据
	 * @param  Mixed  $data   数据
	 * @param  String $indent 缩进字符，默认4个空格
	 * @return JSON
	 */
	static public function jsonFormat($data, $indent = null) {

		// 将urlencode的内容进行urldecode
		$data = urldecode($data);

		// 缩进处理
		$ret = '';
		$pos = 0;
		$length = strlen($data);
		$indent = isset($indent) ? $indent : '&nbsp;&nbsp;&nbsp;&nbsp;';
		$newline = "<br />";
		$prevchar = '';
		$outofquotes = true;

		for ($i = 0; $i <= $length; $i++) {

			$char = substr($data, $i, 1);

			if ($char == '"' && $prevchar != '\\') {
				$outofquotes = !$outofquotes;
			} else if (($char == '}' || $char == ']') && $outofquotes) {
				$ret .= $newline;
				$pos --;
				for ($j = 0; $j < $pos; $j++) {
					$ret .= $indent;
				}
			}
			if ($char == '}' || $char == '{' || $char == '[' || $char == ']' || $char == ':' || $char == '"' || $char == ',') {
				$ret .= $char;
			} else {
				$ret .= '<b style="color:#00a65a">' . $char . '</b>';
			}


			if (($char == ',' || $char == '{' || $char == '[') && $outofquotes) {
				$ret .= $newline;
				if ($char == '{' || $char == '[') {
					$pos ++;
				}

				for ($j = 0; $j < $pos; $j++) {
					$ret .= $indent;
				}
			}

			$prevchar = $char;
		}

		return $ret;
	}

	/**
	 * 计算是否在指定范围时间点内
	 * @param  integer $period 计算可用时间点
	 * @param  integer $hour   小时
	 * @param  integer $minute 分钟
	 * @param  integer $second 秒
	 * @return Bool
	 */
	static public function keepTime($period = 1, $hour = 0, $minute = 55, $second = 45) {

		$periods = array();
		$mod = 24 % $period;

		if ($mod === 0) {
			if ($period === 1) {
				$periods[] = 24;
			} else {
				$except = 24 / $period;
				for ($i = 0; $i < $except; $i++) {
					$hours = ($i * $period) - 1;
					if ($hours === -1) {
						$periods[] = 23;
					} else {
						$periods[] = $hours;
					}
				}
			}
		} else {
			$periods[] = 24;
		}
		sort($periods);

		if (!in_array($hour, $periods)) {
			return FALSE;
		}
		if ($minute != 59) {
			return FALSE;
		}
		if ($second < 45) {
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * 格式化字节数为人可读的格式
	 * @param type $size
	 * @return type
	 */
	public static function sizeFormat($size) {
		$size = (int) $size;
		if ($size < 1024) {
			return $size . " bytes";
		} else if ($size < (1024 * 1024)) {
			$size = round($size / 1024, 1);
			return $size . " KB";
		} else if ($size < (1024 * 1024 * 1024)) {
			$size = round($size / (1024 * 1024), 1);
			return $size . " MB";
		} else {
			$size = round($size / (1024 * 1024 * 1024), 1);
			return $size . " GB";
		}
	}

	public static function crash(Throwable $ex) {
		$loggerCrash = new Log_Database();
		$crashMessage = array(
		    'level' => $ex->getCode(),
		    'file' => $ex->getFile(),
		    'line' => $ex->getLine(),
		    'body' => $ex->getMessage(),
		    'time' => time()
		);
		$loggerCrash->write(array($crashMessage));
	}
	
	public static function checkMobile($mobile, $pattern = FALSE) {

		if (!$pattern) {
			$pattern = '/(^1[34578]\d{9}$)/';
		}

		$result = preg_match($pattern, $mobile, $match);
		if (empty($match)) {
			return FALSE;
		}

		return TRUE;
	}
	
	public static function generatePrizeNum($num) {
    	$numbers = range(10000001,$num+10000001);
   		shuffle($numbers);
    	return implode(',',$numbers);
	}

}
