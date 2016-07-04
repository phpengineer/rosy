<?php
class Controller_Lottery extends Controller_Render {
	
	/**
	 * 在线期彩
	 */
	public function action_online() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
		$pageSize = !empty($params['pageSize']) ? $params['pageSize'] : 20;
		$offset = !empty($params['offset']) ? $params['offset'] : 0;
	
		$lottery = Business::factory('Period')->getLottery($pageSize, $offset);
		$return = array();
		foreach($lottery as $value) {
		$lotteryDetail = array();
			$goods = Business::factory('Goods')->getGoodsByGoodsId($value->sid)->current();
			if(!$goods) {
				continue;
			} else {
				$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
				$userCount = Business::factory('Record')->getRecordByPeriodId($value->id);
				$lotteryDetail['lotteryId'] = $value->id;
				$lotteryDetail['name'] = '第' . $value->no .'期';
				$lotteryDetail['price'] = 1;
				$lotteryDetail['totalTicketCount'] = $goods->price;
				$lotteryDetail['currentTicketCount'] = $value->number;
				$lotteryDetail['totalUserCount'] = $userCount->count();
				$lotteryDetail['goods']['goodsId'] = $goods->id;
				$lotteryDetail['goods']['name'] = $goods->name;
				$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
				$lotteryDetail['goods']['onlineLotteryCount'] = $value->no;
				$return[] = $lotteryDetail;
			}
		}
		
		$this->_data = $return;
	}
	
	/**
	 * 根据商品筛选期彩
	 */
	public function action_select() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
		$pageSize = !empty($params['pageSize']) ? $params['pageSize'] : 20;
		$offset = !empty($params['offset']) ? $params['offset'] : 0;
		$goodsId = !empty($params['goodsId']) ? $params['goodsId'] : 0;
		if($goodsId) {
			return $this->failed(200);
		}
		$result = Business::factory('Period')->getLotteryByGoodsId($goodsId, $pageSize, $offset);
		$return = array();
		foreach($result as $value) {
			$lotteryDetail = array();
			$goods = Business::factory('Goods')->getGoodsByGoodsId($value->sid)->current();
			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
			$userCount = Business::factory('Record')->getRecordByPeriodId($value->id);
			$lotteryDetail['lotteryId'] = $value->id;
			$lotteryDetail['name'] = '第' . $value->no .'期';
			$lotteryDetail['price'] = 1;
			$lotteryDetail['totalTicketCount'] = $goods->price;
			$lotteryDetail['currentTicketCount'] = $value->number;
			$lotteryDetail['totalUserCount'] = $userCount->count();
			$lotteryDetail['goods']['goodsId'] = $goods->id;
			$lotteryDetail['goods']['name'] = $goods->name;
			$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
			$lotteryDetail['goods']['onlineLotteryCount'] = $value->no;
			$return[] = $lotteryDetail;
		}
		
		$this->_data = $return;
	}
	
	/**
	 * 期彩详情
	 */
	public function action_detail() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
		$lotteryId = !empty($params['lotteryId']) ? $params['lotteryId'] : 0;
		$value = Business::factory('Period')->getLotteryById($lotteryId)->current();
		$lotteryDetail = array();
		$goods = Business::factory('Goods')->getGoodsByGoodsId($value->sid)->current();
		$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
		$userCount = Business::factory('Record')->getRecordByPeriodId($value->id);
		$lotteryDetail['lotteryId'] = $value->id;
		$lotteryDetail['name'] = '第' . $value->no .'期';
		$lotteryDetail['price'] = 1;
		$lotteryDetail['totalTicketCount'] = $goods->price;
		$lotteryDetail['currentTicketCount'] = $value->number;
		$lotteryDetail['totalUserCount'] = $userCount->count();
		$lotteryDetail['state'] = $value->state;
		$lotteryDetail['completeTime'] = $value->kaijang_time;
		$lotteryDetail['goods']['goodsId'] = $goods->id;
		$lotteryDetail['goods']['name'] = $goods->name;
		$lotteryDetail['goods']['price'] = $goods->price;
		$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
		$lotteryDetail['goods']['onlineLotteryCount'] = $value->no;
		if($value->state == Dao_Period::STATE_COMPLETE) {
			$lotteryDetail['luckyTicket']['ticketId'] = $value->id;
			$lotteryDetail['luckyTicket']['code'] = $value->no;
			$lotteryDetail['luckyDog']['userId'] = $value->uid;
			$user = Business::factory('User')->getUserByUserId($value->uid);
			$lotteryDetail['luckyDog']['username'] = $user->mobile ? $user->mobile : $user->username;
		} else {
			$lotteryDetail['luckyTicket']['ticketId'] = 0;
			$lotteryDetail['luckyTicket']['code'] = 0;
			$lotteryDetail['luckyDog']['userId'] = 0;
			$lotteryDetail['luckyDog']['username'] = 0;
		}
		
		$this->_data = $lotteryDetail;
	}
	
	/**
	 * 开奖期彩
	 */
	public function action_complete() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
		$pageSize = !empty($params['pageSize']) ? $params['pageSize'] : 20;
		$offset = !empty($params['offset']) ? $params['offset'] : 0;
		$lottery = Business::factory('Period')->getCompleteLottery($offset, $pageSize);
		$return = array();
		foreach($lottery as $value) {
			$lotteryDetail = array();
			$goods = Business::factory('Goods')->getGoodsByGoodsId($value->sid)->current();
			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
			$userCount = Business::factory('Record')->getRecordByPeriodId($value->id);
			$lotteryDetail['lotteryId'] = $value->id;
			$lotteryDetail['name'] = '第' . $value->no .'期';
			$lotteryDetail['price'] = 1;
			$lotteryDetail['totalTicketCount'] = $goods->price;
			$lotteryDetail['totalUserCount'] = $userCount->count();
			$lotteryDetail['completeTime'] = $value->kaijang_time;
			$lotteryDetail['goods']['goodsId'] = $goods->id;
			$lotteryDetail['goods']['name'] = $goods->name;
			$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
			if($value->state == Dao_Period::STATE_COMPLETE) {
				$lotteryDetail['luckyTicket']['ticketId'] = $value->id;
				$lotteryDetail['luckyTicket']['code'] = $value->no;
				$lotteryDetail['luckyDog']['userId'] = $value->uid;
				$user = Business::factory('User')->getUserByUserId($value->uid);
				$lotteryDetail['luckyDog']['username'] = $user->mobile ? $user->mobile : $user->username;
			} else {
				$lotteryDetail['luckyTicket']['ticketId'] = 0;
				$lotteryDetail['luckyTicket']['code'] = 0;
				$lotteryDetail['luckyDog']['userId'] = 0;
				$lotteryDetail['luckyDog']['username'] = 0;
			}
			$return[] = $lotteryDetail;
		}
		$this->_data = $return;
	}
}