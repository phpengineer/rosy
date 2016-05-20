<?php
/**
 * 用户控制
 */
class Controller_User extends Controller_Render {

	/**
	 * 播放接口
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

}