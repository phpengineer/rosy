<?php
/*
 * Created on 2016
 * 商品图片逻辑层
 */
 class Business_Picture extends Business { 

 	public function getPictureByCoverId($coverId) {
 		return Dao::factory('Picture')->getPictureByCoverId($coverId);
 	}
 }
?>
