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
				$return[$key]['typeID'] = $type->id;
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
	 	$pageSize = !empty(trim($params['pageSize'])) ? $params['pageSize'] : 20;
	 	$offset = !empty($params['offset']) ? $params['offset'] : 0;
	 	$typeId = !empty($parmas['typeID']) ? $params['typeID'] : 0;
	 	$result = Business::factory('Goods')->getGoodsByCategoryId($typeId, $pageSize, $offset);
	 	$return = array();
	 	if($result->count()) {
	 		foreach($result as $key => $goods) {
	 			$lottery = Business::factory('Period')->getLotteryCountByGoodsId($goods->id)->current();
	 			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
	 			$return[$key]['goodsID'] = $goods->id;
	 			$return[$key]['name'] = $goods->name;
	 			$return[$key]['icon'] = $picture->path;
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
	 	$keyword = !empty($parmas['keyword']) ? $params['keyword'] : '';
	 	$result = Business::factory('Goods')->getGoodsByKeyword($keyword, $pageSize, $offset);
	 	$return = array();
	 	if($result->count()) {
	 		foreach($result as $key => $goods) {
	 			$lottery = Business::factory('Period')->getLotteryCountByGoodsId($goods->id)->current();
	 			$picture = Business::factory('Picture')->getPictureByCoverId($goods->cover_id)->current();
	 			$return[$key]['goodsID'] = $goods->id;
	 			$return[$key]['name'] = $goods->name;
	 			$return[$key]['icon'] = $picture->path;
	 			$return[$key]['onlineLotteryCount'] = $lottery->no;
	 		}
	 	}
	 	$this->_data = $return;
	}

}
?>
