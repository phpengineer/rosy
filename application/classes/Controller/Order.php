<?php
/*
 * 订单控制类
  */
 class Controller_Order extends Controller_Render {
 	 	
 	 	/**
 	 	 *  创建订单
 	 	 * @param int lotteryId 期彩Id
 	 	 * @param int ticketCount 份数
 	 	 * @return json 
 	 	 */	
 		public function action_create() {
 			$params = json_decode(Arr::get($_POST, 'params', ''), true);
 			$lotteryId = Arr::get($params, 'lottoryId', 0);
 			$ticketCount = Arr::get($params, 'ticketCount', 0);
 			$userId = Arr::get($params, 'userId', '');
			if(!$ticketCount) {
				return $this->failed(900002);
			}
			$createSn = $this->createSn();
			$order = Business::factory('Order')->create($lotteryId, $this->create_sn(), $ticketCount, $userId, 2);
			if($order) {
				$this->success('成功创建订单!');
			}
 		}
 		
 		/**
 		 * 订单详情
 		 */
 		public function action_detail() {
 			
 		}
 		
 		private function createSn() {
    		return date("YmdHis" ).str_pad( mt_rand( 1, 99999 ), 5, "0", STR_PAD_LEFT );
 		}
 }

?>
