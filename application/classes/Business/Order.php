<?php
 class Business_Order extends Business { 
	
 	public function create($lotteryId, $sn, $price, $userId, $type, $prepay_id='') {
		//TODO:这里的创建爱你逻辑是否和网站一致?

 		$data['uid'] = $userId;
 		$data['pid'] = $lotteryId;
 		$data['create_time'] = $_SERVER['REQUEST_TIME'];
 		$data['number'] = $price;
 		$data['order_id'] = $sn;
 		$data['type'] = $type;//1余额支付；2，微信支付；
 		$data['prepay_id'] = $prepay_id;
 		$period = Dao::factory('Period')->getLotteryById($lotteryId)->current();
 		if($period->state) {
 			return $this->failed(900001);	
 		} else {
 			$goods = Dao::factory('Goods')->getGoodsByGoodsId($period->sid)->current();
 			if(!$goods) {
 				return $this->failed(900000);
 			}
 			$surplus = $goods->price - $period->number;
 			if($surplus < $price) {
 				return $this->failed(900002);
 			}
 		}
 		return Dao::factory('Order')->insert($data);
 	}
 	
 	public function getOrdersByUserId($userId, $pageSize, $offset) {
 		return Dao::factory('Order')->getOrdersByUserId($userId, $pageSize, $offset);
 	}
 	
 	public function getOrderByOrderId($orderId) {
 		return Dao::factory('Order')->getOrderByOrderId($orderId);
 	}
 }
?>
	