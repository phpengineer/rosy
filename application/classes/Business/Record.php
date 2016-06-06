<?php
/*
 * Created on 2016
 * 期彩期数逻辑层
 */
 class Business_Record extends Business { 

 	public function getRecordByPeriodId($pid) {
 		return Dao::factory('Record')->getRecordByPeriodId($pid);
 	}
 }
?>
