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
			if(!$ticketCount) {
				return $this->failed(900002);
			}
			$createSn = $this->createSn();
			
			
 		}
 		
 		private function createSn() {
    		return date("YmdHis" ).str_pad( mt_rand( 1, 99999 ), 5, "0", STR_PAD_LEFT );
 		}
 }

?>
