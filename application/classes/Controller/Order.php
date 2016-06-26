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
 			$params = json_decode(Arr::get($_POST, 'params', ''), true);
			$orderId = !empty($params['orderId']) ? $params['orderId'] : '';
			$userId = !empty($params['userId']) ? $params['userId'] : 0;
			$result = Business::factory('Order')->getOrderByOrderId($orderId)->current();
			$time = time();
			$orderInfo['orderId'] =  $result->order_id;
			$orderInfo['ticketCount'] = $result->number; 
			$orderInfo['totalPrice'] = $result->number;
			$period = Business::factory('Period')->getLotteryById($result->pid)->current();
			if($result->code == 'OK') {
				$orderInfo['state'] = 1;
				$orderInfo['payTime'] = $result->create_time;
				$orderInfo['payExpiredTime'] = $period->kaijang_time;
			} elseif($result->code == 'FAIL') {
				$orderInfo['state'] = 4;
				$orderInfo['payTime'] = $result->create_time;
				$orderInfo['payExpiredTime'] = $period->kaijang_time;
			} elseif(!$result->code) {
				$orderInfo['state'] = 0;
				$orderInfo['payTime'] = 0;
				$orderInfo['payExpiredTime'] = $period->kaijang_time;
			}
			if($orderInfo['state'] != 4) {
				if($time > $result->kaijang_time) {
					$orderInfo['state'] = 3;
					$orderInfo['payTime'] = 0;
					$orderInfo['payExpiredTime'] = $period->kaijang_time;
				}
			}
			
			$orderInfo['ticket'] = array(
				'ticketId' => $period->id,
				'code' => $period->no
			);
			$orderInfo['detail'] = $result->msg;
			$lotteryDetail = array();
			$goods = Business::factory('Goods')->getGoodsByGoodsId($period->sid)->current();
			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
			$userCount = Business::factory('Record')->getRecordByPeriodId($period->id);
			if($period->state == 0 || $period->state == 1) {
				$lotteryDetail['lotteryId'] = $period->id;
				$lotteryDetail['name'] = '第' . $period->no .'期';
				$lotteryDetail['price'] = $goods->price;
				$lotteryDetail['totalTicketCount'] = $goods->price;
				$lotteryDetail['currentTicketCount'] = $period->number;
				$lotteryDetail['totalUserCount'] = $userCount->count();
				$lotteryDetail['goods']['goodsId'] = $goods->id;
				$lotteryDetail['goods']['name'] = $goods->name;
				$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
				$lotteryDetail['goods']['onlineLotteryCount'] = $period->no;
			} else {
				$lotteryDetail['lotteryId'] = $period->id;
				$lotteryDetail['name'] = '第' . $period->no .'期';
				$lotteryDetail['price'] = $goods->price;
				$lotteryDetail['totalTicketCount'] = $goods->price;
				$lotteryDetail['totalUserCount'] = $userCount->count();
				$lotteryDetail['completeTime'] = $period->kaijang_time;
				$lotteryDetail['goods']['goodsId'] = $goods->id;
				$lotteryDetail['goods']['name'] = $goods->name;
				$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
				$lotteryDetail['luckyTicket']['ticketId'] = $period->id;
				$lotteryDetail['luckyTicket']['code'] = $period->no;
				$lotteryDetail['luckyDog']['userId'] = $period->uid;
				$user = Business::factory('User')->getUserByUserId($period->uid);
				$lotteryDetail['luckyDog']['username'] = $user->mobile ? $user->mobile : $user->username;
			}
			$return[] = $orderInfo;
			$return['lottery'] = $lotteryDetail;
			
 		}
 		
 		private function createSn() {
    		return date("YmdHis" ).str_pad( mt_rand( 1, 99999 ), 5, "0", STR_PAD_LEFT );
 		}
 }

?>
