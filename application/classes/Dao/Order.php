<?php

/**
 * 商品期数数据访问层
 */
class Dao_Order extends Dao {

	protected $_db = 'default';
	protected $_tableName = 'shop_order';
	protected $_primaryKey = 'id';
	protected $_modelName = 'Model_Order';

	const STATE_ON = 0; // 状态:进行中
	const STATE_JIANG = 1; // 状态：开奖中
	const STATE_COMPLETE = 2;//状态：结束
    
    public function insert(array $data) {
    	return DB::insert($this->_tableName)
    		->columns(array_keys($data))
    		->values(array_values($data))
    		->execute();
    }
    
    public function getOrdersByUserId($userId, $pageSize, $offset) {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('uid', '=', $userId)
    		->offset(($offset>1 ? ($offset-1)*$pageSize : 0))
    		->limit($pageSize)
    		->as_object($this->_modelName)
    		->execute();
    }
    

}
