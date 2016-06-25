<?php
/**
 * 用户设置逻辑层
 */
class Business_User extends Business {

	/**
	 * 更新用户信息逻辑
	 */
	public function update($params) {
		$userId = Arr::get($params, 'userId', 0);
		$userToUpdate['address'] = Arr::get($params, 'address', '');
		return Dao::factory('User')->updateByUserId($userId, $userToUpdate);
	}
	
	public function insert($values) {
		return Dao::factory('User')->insert($values);
	}
	
	public function getUserByMobile($mobile) {
		return Dao::factory('User')->getUserByMobile($mobile);
	}
	
	public function getUserByUsername($username) {
		return Dao::factory('User')->getUserByUsername($username);
	}
	
	public function getUserByUserId($userId) {
		return Dao::factory('User')->getUserByUserId($userId);
	}
	
	public function getUserBynickname($nickname) {
		return Dao::factory('User')->getUserBynickname($nickname);
	}
	
	public function updateByUserId($userId, $value) {
		return Dao::factory('User')->updateByUserId($userId, $value);
	}
	

}