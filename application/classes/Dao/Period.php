<?php

/**
 * 商品期数数据访问层
 * @author renhai
 */
class Dao_Period extends Dao {

	protected $_db = 'default';
	protected $_tableName = 'shop_period';
	protected $_primaryKey = 'id';
	protected $_modelName = 'Model_Period';

	const STATE_DELETED = 0; // 状态-删除
	const STATE_ON = 1; // 状态-正常

	
	
    
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
    

}
