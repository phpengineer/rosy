<?php
/*
 * Created on 2016
 * 期彩期数逻辑层
 */
 class Business_Period extends Business { 

 	public function getLotteryCountByGoodsId($sid) {
 		return Dao::factory('Period')->getLotteryCountByGoodsId($sid);
 	}
 	
 	public function getLottery($pageSize, $offset) {
 		return Dao::factory('Period')->getLottery($pageSize, $offset);
 	}
 }
?>
