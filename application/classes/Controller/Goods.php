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

}
?>
