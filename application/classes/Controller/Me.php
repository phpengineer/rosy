<?php
class Controller_User extends Controller_Render {
	
	/**
	 * 我的中奖
	 */
	public function action_prize() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
		$pageSize = !empty($params['pageSize']) ? $params['pageSize'] : 20;
		$offset = !empty($params['offset']) ? $params['offset'] : 0;
		$userId = !empty($params['userID']) ? $params['userID'] : 0;
		$result = Business::factory('Period')->getPrizeByUserId($userId, $pageSize, $offset);
		$return = array();
		foreach($result as $value) {
			$lotteryDetail = array();
			$goods = Business::factory('Goods')->getGoodsByGoodsId($value->sid)->current();
			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
			$lotteryDetail['lotteryID'] = $lottery->no;
			$lotteryDetail['name'] = '第' . $lottery->no .'期';
			$lotteryDetail['price'] = $goods->price;
			$lotteryDetail['completeTime'] = $value->kaijiang_time;
			$lotteryDetail['goods']['goodsID'] = $goods->id;
			$lotteryDetail['goods']['name'] = $goods->name;
			$lotteryDetail['goods']['icon'] = Kohana::$config->load('default.host') . $picture->path;
			if($value->state == Dao_Period::STATE_COMPLETE) {
				$lotteryDetail['luckyTicket']['ticketID'] = $value->id;
				$lotteryDetail['luckyTicket']['code'] = $value->no;
			} else {
				$lotteryDetail['luckyTicket']['ticketID'] = 0;
				$lotteryDetail['luckyTicket']['code'] = 0;
			}
			$return[] = $lotteryDetail;
		}
		$this->_data = $return;
	}
}