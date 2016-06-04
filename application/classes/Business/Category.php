<?php
/*
 *  商品分类逻辑层
 */
class Business_Category extends Business {

	/**
	 * 获取商品分类信息
	 */
	public function getGoodsCategory() {
		return Dao::factory('Category')->getGoodsCategory();
	}
}
?>
