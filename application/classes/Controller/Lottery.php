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
			$lotteryDetail['totalTicketCount'] = $lottery->number;
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
			$lotteryDetail['totalTicketCount'] = $lottery->number;
			$lotteryDetail['totalUserCount'] = $userCount->count();
			$lotteryDetail['goods']['goodsID'] = $goods->id;
			$lotteryDetail['goods']['name'] = $goods->name;
			$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
			$lotteryDetail['goods']['onlineLotteryCount'] = $lottery->no;
			$return[] = $lotteryDetail;
		}
		
		$this->_data = $return;
	}
	
	public function action_detail() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
		$lotteryId = !empty($params['lotteryID']) ? $params['lotteryID'] : 0;
		$value = Business::factory('Period')->getLotteryById($lotteryId);
		$lotteryDetail = array();
		$goods = Business::factory('Goods')->getGoodsByGoodsId($value->sid)->current();
		$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
		$userCount = Business::factory('Record')->getRecordByPeriodId($value->id);
		$lotteryDetail['lotteryID'] = $lottery->no;
		$lotteryDetail['name'] = '第' . $lottery->no .'期';
		$lotteryDetail['price'] = $goods->price;
		$lotteryDetail['totalTicketCount'] = $goods->price;
		$lotteryDetail['totalTicketCount'] = $lottery->number;
		$lotteryDetail['totalUserCount'] = $userCount->count();
		$lotteryDetail['state'] = $value->state;
		$lotteryDetail['completeTime'] = $value->kaijiang_time;
		$lotteryDetail['goods']['goodsID'] = $goods->id;
		$lotteryDetail['goods']['name'] = $goods->name;
		$lotteryDetail['goods']['price'] = $goods->price;
		$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
		$lotteryDetail['goods']['onlineLotteryCount'] = $lottery->no;
		$return[] = $lotteryDetail;
		$this->_data = $return;
	}
}