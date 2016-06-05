<?php
/*
 * Created on 2016
 * 商品逻辑层
 */
 class Business_Goods extends Business { 

 	public function getGoodsByCategoryId($categoryId, $pageSize, $offset) {
 		return Dao::factory('Goods')->getGoodsByCategoryId($categoryId, $pageSize, $offset);
 	}
 }
?>
