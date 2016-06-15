<?php
/**
 * 用户控制
 */
class Controller_User extends Controller_Render {

	/**
	 * 登记地址接口
	 */
	public function action_address() {
		$params = Arr::get($_POST, 'params', '');
		$address = json_decode($params, true);
		if(empty($address['address']))  {
			return $this->failed(130000);
		}
		
		$result = Business::factory('User')->update($address);
		if($result) {
			$this->success('设置成功');
		} else {
			$this->failed(130001);
		}

	}
	
	/**
	 * 注册
	 */
	 public function action_register() {
	 	$params = json_decode(Arr::get($_POST, 'params', ''), true);
	 	$username = !empty(trim($params['username'])) ? $params['username'] : '';
	 	$password = !empty($params['password']) ? $params['password'] : '';
	 	$mobile = !empty($params['mobile']) ? $params['mobile'] : 0;
	 	$vcode = $params['vcode'];
	 	$values = array();
	 	$data = array();
	 	if(!$username || !$password) {
	 		return $this->failed(100002);
	 	} 
	 	if(!$mobile) {
	 		return $this->failed(100103);
	 	}
	 	$users = Business::factory('User')->getUserByMobile($mobile);
	 	if($users->count()) {
	 		return $this->faild(100101);
	 	}
	 	$values['username'] = $username;
	 	$values['password'] = md5($password);
	 	$values['mobile'] = $mobile;
	 	//此处需要验证手机验证码，通过则插入
	 	$redisCode = 1234;
	 	if($redisCode != $vcode) {
	 		return $this->failed(100201);
	 	}
	 	$insertId = Business::factory('User')->insert($values);
	 	if($insertId) {
	 		$result = Business::factory('User')->getUserByUserId($insertId)->current();
	 		$data['userId'] = $result->id;
	 		$data['username'] = $result->username;
	 		$data['avatar'] = $result->headimgurl;
	 		$data['mobile'] = $result->mobile;
	 		$data['address'] = $result->address;
	 		$data['token'] = 'dfafasdfdsafasdf';//此token放到redis里，redis控制是否过期
	 		unset($result);
	 		$this->_data = $data;
	 	} else {
	 		$this->faild(100104);
	 	}
	 	
	 	
	 }
	 
	 /**
	  * 登陆
	  * 兼容两种模式：
	  * 	1、账号密码登陆
	  * 	2、账号，手机验证码快捷登陆
	  */
	 public function action_login() {
	 	$params = json_decode(Arr::get($_POST, 'params', ''), true);
	 	$username = !empty(trim($params['username'])) ? $params['username'] : '';
	 	$password = !empty($params['password']) ? $params['password'] : '';
	 	$mobile = !empty($params['mobile']) ? $params['mobile'] : 0;
	 	$vcode = !empty($params['vcode']) ? $params['vcode'] : 0;
	 	$data = array();
	 	if($password && $username) {
	 		$user = Business::factory('User')->getUserByUsername($username)->current();
	 		if($user) {
	 			if(md5($password) != $user->password) {
	 				return $this->failed(110001);
	 			}
	 		} else {
	 			return $this->failed(110000);
	 		}
	 	} else {
	 		$redisCode = 1234;
	 		if($redisCode != $vcode) {
	 			return $this->failed(110101);
	 		}
	 		$user = Business::factory('User')->getUserByMobile($mobile)->current();
	 		if(!$user) {
	 			return $this->failed(110000);
	 		}
	 	}
	 	$data['userId'] = $user->id;
 		$data['username'] = $user->username;
 		$data['avatar'] = $user->headimgurl;
 		$data['mobile'] = $user->mobile;
 		$data['address'] = $user->address;
 		$data['token'] = 'dfafasdfdsafasdf';//此token放到redis里，redis控制是否过期
 		unset($user);
 		$this->_data = $data;
	 }
	 
	 /**
	  * 退出登录
	  */
	 public function action_logout() {
	 	$this->success('退出登陆');
	 }
	 
	 /**
	  * 设置图像
	  */
	 public function action_avatar() {
	 	$postImage = file_get_contents('php://input', 'r');
	 	$params = json_decode(Arr::get($_POST, 'params', ''), true);
	 	$userId = !empty($params['userID']) ? $params['userID'] : 0;
	 	if($userId) {
	 		return $this->failed(201);
	 	}
	 	if($postImage) {
	 		//16进制转换成二进制
	 		//$byte = pack("H*",$postImage);
	 		$byte = $postImage;
	 		$im = imagecreatefromstring($byte);
	 		if ($im === false) {
	 			return $this->failed(201);
	 		} else {
	 			$uploadPath = DOCROOT . "/usr/share/nginx/html/rosy/upload/";
	 			if(!is_dir($uploadPath)) {
	 				if(!mkdir($uploadPath, 0777, TRUE)) {
						return $this->failed(21001);
	 				}
	 			}
	 	
	 			if(!is_writable($uploadPath)) {
	 				$this->failed(21002);
	 			}
	 			$tmpImageFilename = md5(uniqid('yiyuanduobao'));
	 			$extension = '.png';
	 			$sourcePicFilePath = $uploadPath . $tmpImageFilename . $extension;
	 			header('Content-Type: image/png');
	 			imagepng($im, $sourcePicFilePath);
	 			imagedestroy($im);
	 			//检查图片大小,最高10M
	 			$imageSize = filesize($sourcePicFilePath);
	 			if($imageSize && ($imageSize > (1024*1024*10))) {
	 				@unlink($sourcePicFilePath);
	 				return $this->failed(21003);
	 			} else {
	 				$values = array('userID'=> $userId, 'headimgurl' => Kohana::$config->load('default.host') . $sourcePicFilePath);
	 				$result = Business::factory('User')->update($values);
	 				if($result) {
	 					$this->_data = $values['headimgurl'];
	 				}
	 			}
	 			
	 		}
	 	}
	 }
	 
	 /**
	  * 设置手机号
	  */
	 public function action_mobile() {
	 	$params = json_decode(Arr::get($_POST, 'params', ''), true);
	 	$userId = !empty($params['userID']) ? $params['userID'] : 0;
	 	$oldVcode = !empty($params['oldvcode']) ? $params['oldvcode'] : '';
	 	$newVcode = !empty($params['newvcode']) ? $params['newvcode'] : '';
	 	$newMobile = !empty($params['newMobile']) ? $params['newMobile'] : 0;
	 	$oldMobile = !empty($params['oldMobile']) ? $params['oldMobile'] : 0;
	 	if(Cache_Key::vcode($oldMobile)) {
	 		return $this->failed(120001);
	 	}
	 	if($oldVcode != Cache_Key::vcode($oldMobile))  {
	 		return $this->failed(120000);
	 	}
	 	if(!Misc::checkMobile($newMobile)) {
	 		return $this->failed(120100);
	 	}
	 	$user = Business::factory('User')->getUserByMobile($newMobile);
	 	if($user->count()) {
	 		return $this->failed(120101);
	 	}
	 	if(Cache_Key::vcode($newMobile)) {
	 		return $this->failed(120103);
	 	}
	 	if($newVcode != Cache_Key::vcode($newMobile))  {
	 		return $this->failed(120102);
	 	}
	 	$values = array('userID' => $userId, 'mobile' => $newMobile);
	 	$result = Business::factory('User')->update($values);
	 	if($result) {
	 		$this->success('设置手机号成功');
	 	} else {
	 		$this->failed(130000);
	 	}
	 	
	 	
	 	
	 	
	 }

}