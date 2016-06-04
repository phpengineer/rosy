<?php
/*
 * 系统服务控制
 * Created on 2016
 * @xiongrenhai
 */
 class Controller_Service extends Controller_Render {
 	 	
 	 	/**
 	 	 *  获取验证码
 	 	 * @param int mobile
 	 	 * @return json 
 	 	 */	
 		public function action_vcode() {
 			$params = json_decode(Arr::get($_POST, 'params', ''), true);
			$mobile = !empty($params['mobile']) ? $params['mobile'] : 0; 
			if(!Misc::checkMobile($mobile))  {
				return $this->failed(400);
			}
			$redis = new Redisd('count');
			$vcode = $redis->get(Cache_Key::vcode($mobile));
			if($vcode) {
				return $this->faild(401);
			}
			$vcode = mt_rand(1000,9999);
			$redis->set(Cache_Key::Vcode($mobile), $vcode, 60);
			$this->_data = array('code' => $vcode);
 		}
 }

?>
