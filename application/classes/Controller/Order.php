<?php
/*
 * 订单控制类
  */
 class Controller_Order extends Controller_Render {
 	 	
 	 	/**
 	 	 *  创建订单
 	 	 * @param int lotteryId 期彩ID
 	 	 * @param int ticketCount 份数
 	 	 * @return json 
 	 	 */	
 		public function action_create() {
 			$params = json_decode(Arr::get($_POST, 'params', ''), true);

 		}
 }

?>
