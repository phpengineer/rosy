<?php
/*
 * 商品控制
 * Created on 2016
 *
 */
class Controller_Goods extends Controller_Render {
	/**
	 * 播放接口
	 */
	public function action_types() {
		$types = Business::factory('Category')->getGoodsCategory();
		$return = array();
		if($types->count()) {
			foreach($types as $key => $type) {
				$return[$key]['typeId'] = $type->id;
				$return[$key]['name'] = $type->title;
				$return[$key]['icon'] = $type->icon;
			}
		}
		$this->_data = $return;
	}
	
	/**
	 *  根据商品类别获取商品列表
	 */
	public function action_select() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
	 	$pageSize = !empty($params['pageSize']) ? $params['pageSize'] : 20;
	 	$offset = !empty($params['offset']) ? $params['offset'] : 0;
	 	$typeId = !empty($params['typeId']) ? $params['typeId'] : 0;
	 	$result = Business::factory('Goods')->getGoodsByCategoryId($typeId, $pageSize, $offset);
	 	$return = array();
	 	if($result->count()) {
	 		foreach($result as $key => $goods) {
	 			$lottery = Business::factory('Period')->getLotteryCountByGoodsId($goods->id)->current();
	 			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
	 			$return[$key]['goodsId'] = $goods->id;
	 			$return[$key]['name'] = $goods->name;
	 			$return[$key]['icon'] = Kohana::$config->load('default.host') . $picture->path;
	 			$return[$key]['onlineLotteryCount'] = $lottery->no;
	 		}
	 	}
	 	$this->_data = $return;
	}
	
	/**
	 * 根据关键字筛选商品
	 * @param string keyword
	 */
	public function action_search() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
	 	$pageSize = !empty(trim($params['pageSize'])) ? $params['pageSize'] : 20;
	 	$offset = !empty($params['offset']) ? $params['offset'] : 0;
	 	$keyword = !empty($params['keyword']) ? $params['keyword'] : '';
	 	$result = Business::factory('Goods')->getGoodsByKeyword($keyword, $pageSize, $offset);
	 	$return = array();
	 	if($result->count()) {
	 		foreach($result as $key => $goods) {
	 			$lottery = Business::factory('Period')->getLotteryCountByGoodsId($goods->id)->current();
	 			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
	 			$return[$key]['goodsId'] = $goods->id;
	 			$return[$key]['name'] = $goods->name;
	 			$return[$key]['icon'] = Kohana::$config->load('default.host') . $picture->path;
	 			$return[$key]['onlineLotteryCount'] = $lottery->no;
	 		}
	 	}
	 	$this->_data = $return;
	}
	
	/**
	 * 商品详情
	 */
	public function action_detail() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
	 	$goodsId = !empty(trim($params['goodsId'])) ? $params['goodsId'] : 0;
	 	if(!$goodsId) {
	 		return $this->failed(201);
	 	}
	 	$result = Business::factory('Goods')->getGoodsByGoodsId($goodsId);
	 	$return = array();
	 	if($result->count()) {
	 		$goods = $result->current();
 			$lottery = Business::factory('Period')->getLotteryCountByGoodsId($goods->id)->current();
 			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
 			$suppliers = Business::factory('Supplier')->getSupplierBySupplierId($goods->supplier_id);
 			$lotteries = Business::factory('Period')->getLotteryById($lottery->id);
 			$return['goodsId'] = $goods->id;
 			$return['name'] = $goods->name;
 			$return['icon'] = Kohana::$config->load('default.host') . $picture->path;
 			$return['image'] = array(Kohana::$config->load('default.host') . $picture->picture);
 			$return['price'] = $goods->price;
 			$return['detail'] = $goods->content;
 			$return['onlineLotteryCount'] = $lottery->no;
 			if($suppliers->count()) {
 				$supplier = $suppliers->current();
 				$return['supplier'] = array(
 					'supplierId' => $supplier->supplier_id,
 					'name' => $supplier->name,
 					'tel' => $supplier->phone,
 					'address' => $supplier->address
 				);
 			} else {
 				$return['supplier'] = array(
 					'supplierId' => 0,
 					'name' => '',
 					'tel' => '',
 					'address' => ''
 				);
 			}
 			$return['lotteries'] = array();
 			foreach($lotteries as $key => $value) {
 				$lotteryDetail = array();
 				$lotteryDetail['lotteryId'] = $value->id;
 				$goodsResult = Business::factory('Goods')->getGoodsByGoodsId($value->sid);
 				$userCount = Business::factory('Record')->getRecordByPeriodId($value->id);
 				$lotteryDetail['name'] = '第' . $value->no .'期';
 				$lotteryDetail['totalTicketCount'] = $goodsResult->price;
 				$lotteryDetail['currentTicketCount'] = $value->number;
 				$lotteryDetail['totalUserCount'] = $userCount->count();
 				$return['lotteries'] = $lotteryDetail;
 			}
	 	}
	 	$this->_data = $return;
	}

}
?>
