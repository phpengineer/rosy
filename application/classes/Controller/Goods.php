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
	 			$lotteries = Business::factory('Period')->getOnlineLotteryByGoodsId($goods->id);
	 			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
	 			$return[$key]['goodsId'] = $goods->id;
	 			$return[$key]['name'] = $goods->name;
	 			$return[$key]['icon'] = Kohana::$config->load('default.host') . $picture->path;
	 			$return[$key]['onlineLotteryCount'] = count($lotteries);
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
	 	$pageSize = !empty($params['pageSize']) ? $params['pageSize'] : 20;
	 	$offset = !empty($params['offset']) ? $params['offset'] : 0;
	 	$keyword = !empty($params['keyword']) ? $params['keyword'] : '';
	 	$result = Business::factory('Goods')->getGoodsByKeyword($keyword, $pageSize, $offset);
	 	$return = array();
	 	if($result->count()) {
	 		foreach($result as $key => $goods) {
				$lotteries = Business::factory('Period')->getOnlineLotteryByGoodsId($goods->id);
	 			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
	 			$return[$key]['goodsId'] = $goods->id;
	 			$return[$key]['name'] = $goods->name;
	 			$return[$key]['icon'] = Kohana::$config->load('default.host') . $picture->path;
	 			$return[$key]['onlineLotteryCount'] = count($lotteries);
	 		}
	 	}
	 	$this->_data = $return;
	}
	
	/**
	 * 商品详情
	 */
	public function action_detail() {
		$params = json_decode(Arr::get($_POST, 'params', ''), true);
	 	$goodsId = !empty($params['goodsId']) ? $params['goodsId'] : 0;
	 	if(!$goodsId) {
	 		return $this->failed(201);
	 	}
	 	$result = Business::factory('Goods')->getGoodsByGoodsId($goodsId);
	 	$return = array();
	 	if($result->count()) {
	 		$goods = $result->current();

			//TODO:获取所有的goodsID关联的期彩
 			$lotteries = Business::factory('Period')->getOnlineLotteryByGoodsId($goods->id);
 			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
 			$suppliers = Business::factory('Supplier')->getSupplierBySupplierId($goods->supplier_id);
 			$return['goodsId'] = $goods->id;
 			$return['name'] = $goods->name;
 			$return['icon'] = Kohana::$config->load('default.host') . $picture->path;
			$return['onlineLotteryCount'] = count($lotteries);

			//TODO:这里images应该取得是$goods->content那一堆中的图片url,并且要拼接
			//&lt;p style=&quot;text-align: center;&quot;&gt;&lt;img src=&quot;/Picture/Ueditor/2016-01-03/568880cc6e46e.jpg&quot;/&gt;&lt;img src=&quot;/Picture/Ueditor/2016-01-03/568880cc7ea2a.jpg&quot;/&gt;&lt;img src=&quot;/Picture/Ueditor/2016-01-03/568880cc93a1f.jpg&quot;/&gt;&lt;img src=&quot;/Picture/Ueditor/2016-01-03/568880cd1db84.jpg&quot;/&gt;&lt;img src=&quot;/Picture/Ueditor/2016-01-03/568880cd43905.jpg&quot;/&gt;&lt;img src=&quot;/Picture/Ueditor/2016-01-03/568880cd67f16.jpg&quot;/&gt;&lt;/p&gt;
 			//这个字符串的分割规则,先按照";"分割,遍历去除不包含"/"的,然后在按照"&"分割,去除不包含"/"的
			$return['images'] = array(Kohana::$config->load('default.host') . $picture->path);
 			$return['price'] = $goods->price;
 			$return['detail'] = $goods->description;

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
 				$goodsResult = Business::factory('Goods')->getGoodsByGoodsId($value->sid)->current();
 				$userCount = Business::factory('Record')->getRecordByPeriodId($value->id);
 				$lotteryDetail['name'] = '第' . $value->no .'期';
 				$lotteryDetail['totalTicketCount'] = $goodsResult->price;
 				$lotteryDetail['currentTicketCount'] = $value->number;
 				$lotteryDetail['totalUserCount'] = $userCount->count();
 				$return['lotteries'][] = $lotteryDetail;
 			}
	 	}
	 	$this->_data = $return;
	}
}
?>
