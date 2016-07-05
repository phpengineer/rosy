<?php
/*
 * Created on 2016
 * 期彩期数逻辑层
 */
 class Business_Period extends Business {
	 public function getOnlineLotteryByGoodsId($goodsId) {
		 return Dao::factory('Period')->getOnlineLotteryByGoodsId($goodsId);
	 }

 	public function getLotteryCountByGoodsId($sid) {
 		return Dao::factory('Period')->getLotteryCountByGoodsId($sid);
 	}
 	
 	public function getLottery($pageSize, $offset) {
 		return Dao::factory('Period')->getLottery($pageSize, $offset);
 	}
 	
 	public function getLotteryByGoodsId($goodsId, $pageSize, $offset) {
 		return Dao::factory('Period')->getLotteryByGoodsId($goodsId, $pageSize, $offset);
 	}
 	
 	public function getLotteryById($id) {
 		return Dao::factory('Period')->getLotteryById($id);
 	}
 	
 	public function getCompleteLottery() {
 		return Dao::factory('Period')->getCompleteLottery();
 	}
 	
 	public function getPrizeByUserId($userId, $pageSize, $offset) {
 		return Dao::factory('Period')->getPrizeByUserId($userId, $pageSize, $offset);
 	}
 }
?>
