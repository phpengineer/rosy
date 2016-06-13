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
	 	$vcode = $params['vcode'];
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

}