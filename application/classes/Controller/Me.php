<?php
class Controller_User extends Controller_Render {
	
	/**
	 * 我的中奖
	 */
	public function action_prize() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
		$pageSize = !empty($params['pageSize']) ? $params['pageSize'] : 20;
		$offset = !empty($params['offset']) ? $params['offset'] : 0;
		$userId = !empty($params['userId']) ? $params['userId'] : 0;
		$result = Business::factory('Period')->getPrizeByUserId($userId, $pageSize, $offset);
		$return = array();
		foreach($result as $value) {
			$lotteryDetail = array();
			$goods = Business::factory('Goods')->getGoodsByGoodsId($value->sid)->current();
			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
			$lotteryDetail['lotteryId'] = $lottery->id;
			$lotteryDetail['name'] = '第' . $lottery->no .'期';
			$lotteryDetail['price'] = $goods->price;
			$lotteryDetail['completeTime'] = $value->kaijang_time;
			$lotteryDetail['goods']['goodsId'] = $goods->id;
			$lotteryDetail['goods']['name'] = $goods->name;
			$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
			if($value->state == Dao_Period::STATE_COMPLETE) {
				$lotteryDetail['luckyTicket']['ticketId'] = $value->id;
				$lotteryDetail['luckyTicket']['code'] = $value->no;
			} else {
				$lotteryDetail['luckyTicket']['ticketId'] = 0;
				$lotteryDetail['luckyTicket']['code'] = 0;
			}
			$return[] = $lotteryDetail;
		}
		$this->_data = $return;
	}
	
	
	/**
	 * 我的订单
	 */
	public function action_orders() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
		$pageSize = !empty($params['pageSize']) ? $params['pageSize'] : 20;
		$offset = !empty($params['offset']) ? $params['offset'] : 0;
		$userId = !empty($params['userId']) ? $params['userId'] : 0;
		$result = Business::factory('Order')->getOrdersByUserId($userId, $pageSize, $offset);
		$return = array();
		$orderInfo = array();
		$time = time();
		if($result->count()) {
			foreach($result as $key => $value) {
				$lotteryDetail = array();
				$orderInfo['orderId'] =  $value->order_id;
				$orderInfo['ticketCount'] = $value->number; 
				$orderInfo['totalPrice'] = $value->number;
				$period = Business::factory('Period')->getLotteryById($value->pid)->current();
				if($value->code == 'OK') {
					$orderInfo['state'] = 1;
					$orderInfo['payTime'] = $value->create_time;
				} elseif($value->code == 'FAIL') {
					$orderInfo['state'] = 4;
					$orderInfo['payExpiredTime'] = $period->kaijang_time;
				} elseif(!$value->code) {
					$orderInfo['state'] = 0;
				}
				
				if($orderInfo['state'] != 4) {
					if($time > $value->kaijang_time) {
						$orderInfo['state'] = 3;
					}
				}
				
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
				$return[]['lottery'] = $lotteryDetail;
			}
			
		}
		$this->_data = $return;
	}
}