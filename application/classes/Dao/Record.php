<?php

/**
 * 购买记录访问层
 */
class Dao_Record extends Dao {

	protected $_db = 'default';
	protected $_tableName = 'shop_record';
	protected $_primaryKey = 'id';
	protected $_modelName = 'Model_Record';

	
	
    
    /**
     * 根据period_id 获取购买记录
     * @param int pid
     * @return Ambigous <object, mixed, number, Database_Result_Cached, multitype:>
     */
    public function getRecordByPeriodId($pid) {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('pid', '=', $pid)
    		->as_object($this->_modelName)
    		->execute();
    }
    

}
