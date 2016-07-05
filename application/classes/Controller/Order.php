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
 			$lotteryId = Arr::get($params, 'lotteryId', 0);
 			$ticketCount = Arr::get($params, 'ticketCount', 0);
 			$userId = Arr::get($params, 'userId', '');
			if(!$ticketCount) {
				return $this->failed(900002);
			}

			//TODO:$createSns是干嘛用的?
			$createSn = $this->createSn();
			$order = Business::factory('Order')->create($lotteryId, $createSn, $ticketCount, $userId, 2);
			$data = array();
			if($order) {
				//$this->success('成功创建订单!');
				$data['payData'] = '这里存放用于支付的加密数据';
				$this->_data = $data;
			}
 		}

	 /**
	  *  获取支付数据
	  * @param int orderId 订单Id
	  * @return json
	  */
	 public function action_pay() {
		 $params = json_decode(Arr::get($_POST, 'params', ''), true);
		 $orderId = Arr::get($params, 'orderId', 0);
		 if(!$orderId) {
			 return $this->failed(900002);
		 }

		 //TODO:这里的逻辑是根据orderId获取这个订单用于微信支付的数据
		 $data = array();
		 $data['payData'] = '这里存放用于支付的加密数据';
		 $this->_data = $data;
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

				//TODO:payTime是支付成功时间戳,这里用create_time是否合适?
				$orderInfo['payTime'] = $result->create_time;

				//TODO:payExpiredTime是支付过期的时间戳,用kaijang_time也不合适,应该是创建订单时间加上有效的等待时间,例如10分钟或者30分钟
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

			//TODO:这里应该是一个数组,一个订单因为可能买了不止一份期彩,那么应该生成多个号码,这里是这个订单关联的号码的列表
			$orderInfo['tickets'] = array(
				'ticketId' => $period->id,
				'code' => $period->no
			);
			$orderInfo['detail'] = $result->msg;
			$lotteryDetail = array();
			$goods = Business::factory('Goods')->getGoodsByGoodsId($period->sid)->current();
			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
			$userCount = Business::factory('Record')->getRecordByPeriodId($period->id);
			$lotteries = Business::factory('Period')->getOnlineLotteryByGoodsId($goods->id);
			if($period->state == 0 || $period->state == 1) {
				$lotteryDetail['lotteryId'] = $period->id;
				$lotteryDetail['name'] = '第' . $period->no .'期';
				$lotteryDetail['price'] = 1;
				$lotteryDetail['totalTicketCount'] = $goods->price;
				$lotteryDetail['currentTicketCount'] = $period->number;
				$lotteryDetail['totalUserCount'] = $userCount->count();
				$lotteryDetail['goods']['goodsId'] = $goods->id;
				$lotteryDetail['goods']['name'] = $goods->name;
				$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
				$lotteryDetail['goods']['onlineLotteryCount'] = $lotteries->count();
			} else {
				$lotteryDetail['lotteryId'] = $period->id;
				$lotteryDetail['name'] = '第' . $period->no .'期';
				$lotteryDetail['price'] = 1;
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

				//TODO:当获取用户名的时候,什么时候获取username什么时候获取nickname
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
