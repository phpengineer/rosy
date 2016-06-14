<?php

/**
 * 商品期数数据访问层
 */
class Dao_Period extends Dao {

	protected $_db = 'default';
	protected $_tableName = 'shop_period';
	protected $_primaryKey = 'id';
	protected $_modelName = 'Model_Period';

	const STATE_ON = 0; // 状态:进行中
	const STATE_JIANG = 1; // 状态：开奖中
	const STATE_COMPLETE = 2;//状态：结束

	
	
    
    /**
     *  获取商品期数信息
     * @param int sid
     * @return Ambigous <object, mixed, number, Database_Result_Cached, multitype:>
     */
    public function getLotteryCountByGoodsId($sid) {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('sid', '=', $sid)
    		->as_object($this->_modelName)
    		->execute();
    }
    
    /**
     * 分页获取期彩
     * @param int $pageSize
     * @param int $offset
     * @return Ambigous <object, mixed, number, Database_Result_Cached, multitype:>
     */
    public function getLottery($pageSize, $offset) {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('state', '=', self::STATE_ON)
    		->offset(($offset>1 ? ($offset-1)*$pageSize : 0))
    		->limit($pageSize)
    		->as_object($this->_modelName)
    		->execute();
    }
    
    public function getLotteryByGoodsId($goodsId, $pageSize, $offset) {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('state', '=', self::STATE_ON)
    		->and_where('sid', '=', $goodsId)
    		->offset(($offset>1 ? ($offset-1)*$pageSize : 0))
    		->limit($pageSize)
    		->as_object($this->_modelName)
    		->execute();
    }
    
    public function getLotteryById($id) {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('id', '=', $id)
    		->as_object($this->_modelName)
    		->execute();
    }
    
    public function getCompleteLottery() {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('state', '=', self::STATE_COMPLETE)
    		->as_object($this->_modelName)
    		->execute();
    }
    
    
    public function getPrizeByUserId($userId, $pageSize, $offset) {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('state', '=', self::STATE_COMPLETE)
    		->and_where('uid', '=', $userId)
    		->order_by('kaijiang_time', 'DESC')
    		->offset(($offset>1 ? ($offset-1)*$pageSize : 0))
    		->limit($pageSize)
    		->as_object($this->_modelName)
    		->execute();
    }
    

}
