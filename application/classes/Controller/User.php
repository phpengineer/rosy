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
			$this->failed(130000);
			return;
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
	 	if(!$username || !$password) {
	 		$this->failed(100002);
	 		return;
	 	} 
	 	if(!$mobile) {
	 		$this->failed(100103);
	 		return;
	 	}
	 	$users = Business::factory("User")->getUserByMobile($mobile);
	 	if($users->count() > 0) {
	 		$this->faild(100101);
	 		return;
	 	}
	 	$values['username'] = $username;
	 	$values['password'] = md5($password);
	 	$values['mobile'] = $mobile;
	 	$result = Business::factory("User")->insert($values);
	 	if($result) {
	 		$this->success('注册成功！');
	 	} else {
	 		$this->faild(100104);
	 	}
	 	
	 	
	 }

}