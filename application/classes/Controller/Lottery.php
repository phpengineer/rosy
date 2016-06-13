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
			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
			$userCount = Business::factory('Record')->getRecordByPeriodId($value->id);
			$lotteryDetail['lotteryID'] = $lottery->no;
			$lotteryDetail['name'] = '第' . $lottery->no .'期';
			$lotteryDetail['price'] = $goods->price;
			$lotteryDetail['totalTicketCount'] = $goods->price;
			$lotteryDetail['currentTicketCount'] = $lottery->number;
			$lotteryDetail['totalUserCount'] = $userCount->count();
			$lotteryDetail['goods']['goodsID'] = $goods->id;
			$lotteryDetail['goods']['name'] = $goods->name;
			$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
			$lotteryDetail['goods']['onlineLotteryCount'] = $lottery->no;
			$return[] = $lotteryDetail;
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
		$goodsId = !empty($params['goodsID']) ? $params['goodsID'] : 0;
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
			$lotteryDetail['lotteryID'] = $lottery->no;
			$lotteryDetail['name'] = '第' . $lottery->no .'期';
			$lotteryDetail['price'] = $goods->price;
			$lotteryDetail['totalTicketCount'] = $goods->price;
			$lotteryDetail['currentTicketCount'] = $lottery->number;
			$lotteryDetail['totalUserCount'] = $userCount->count();
			$lotteryDetail['goods']['goodsID'] = $goods->id;
			$lotteryDetail['goods']['name'] = $goods->name;
			$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
			$lotteryDetail['goods']['onlineLotteryCount'] = $lottery->no;
			$return[] = $lotteryDetail;
		}
		
		$this->_data = $return;
	}
	
	/**
	 * 期彩详情
	 */
	public function action_detail() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
		$lotteryId = !empty($params['lotteryID']) ? $params['lotteryID'] : 0;
		$value = Business::factory('Period')->getLotteryById($lotteryId);
		$lotteryDetail = array();
		$return = array();
		$goods = Business::factory('Goods')->getGoodsByGoodsId($value->sid)->current();
		$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
		$userCount = Business::factory('Record')->getRecordByPeriodId($value->id);
		$lotteryDetail['lotteryID'] = $lottery->no;
		$lotteryDetail['name'] = '第' . $lottery->no .'期';
		$lotteryDetail['price'] = $goods->price;
		$lotteryDetail['totalTicketCount'] = $goods->price;
		$lotteryDetail['currentTicketCount'] = $lottery->number;
		$lotteryDetail['totalUserCount'] = $userCount->count();
		$lotteryDetail['state'] = $value->state;
		$lotteryDetail['completeTime'] = $value->kaijiang_time;
		$lotteryDetail['goods']['goodsID'] = $goods->id;
		$lotteryDetail['goods']['name'] = $goods->name;
		$lotteryDetail['goods']['price'] = $goods->price;
		$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
		$lotteryDetail['goods']['onlineLotteryCount'] = $lottery->no;
		if($value->state == Dao_Period::STATE_COMPLETE) {
			$lotteryDetail['luckyTicket']['ticketID'] = $value->id;
			$lotteryDetail['luckyTicket']['code'] = $value->no;
			$lotteryDetail['luckyDog']['userID'] = $value->uid;
			$user = Business::factory('User')->getUserByUserId($value->uid);
			$lotteryDetail['luckyDog']['username'] = $user->mobile ? $user->mobile : $user->username;
		} else {
			$lotteryDetail['luckyTicket']['ticketID'] = 0;
			$lotteryDetail['luckyTicket']['code'] = 0;
			$lotteryDetail['luckyDog']['userID'] = 0;
			$lotteryDetail['luckyDog']['username'] = 0;
		}
		
		$return[] = $lotteryDetail;
		$this->_data = $return;
	}
	
	
	public function action_complete() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
		$pageSize = !empty($params['pageSize']) ? $params['pageSize'] : 20;
		$offset = !empty($params['offset']) ? $params['offset'] : 0;
		$lottery = Business::factory('Period')->getCompleteLottery();
		$return = array();
		foreach($lottery as $value) {
			$lotteryDetail = array();
			$goods = Business::factory('Goods')->getGoodsByGoodsId($value->sid)->current();
			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
			$userCount = Business::factory('Record')->getRecordByPeriodId($value->id);
			$lotteryDetail['lotteryID'] = $lottery->no;
			$lotteryDetail['name'] = '第' . $lottery->no .'期';
			$lotteryDetail['price'] = $goods->price;
			$lotteryDetail['totalTicketCount'] = $goods->price;
			$lotteryDetail['totalUserCount'] = $userCount->count();
			$lotteryDetail['completeTime'] = $value->kaijiang_time;
			$lotteryDetail['goods']['goodsID'] = $goods->id;
			$lotteryDetail['goods']['name'] = $goods->name;
			$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
			if($value->state == Dao_Period::STATE_COMPLETE) {
				$lotteryDetail['luckyTicket']['ticketID'] = $value->id;
				$lotteryDetail['luckyTicket']['code'] = $value->no;
				$lotteryDetail['luckyDog']['userID'] = $value->uid;
				$user = Business::factory('User')->getUserByUserId($value->uid);
				$lotteryDetail['luckyDog']['username'] = $user->mobile ? $user->mobile : $user->username;
			} else {
				$lotteryDetail['luckyTicket']['ticketID'] = 0;
				$lotteryDetail['luckyTicket']['code'] = 0;
				$lotteryDetail['luckyDog']['userID'] = 0;
				$lotteryDetail['luckyDog']['username'] = 0;
			}
			$return[] = $lotteryDetail;
		}
		$this->_data = $return;
	}
}