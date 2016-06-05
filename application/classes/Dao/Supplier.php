<?php

/**
 * 商家信息数据访问层
 */
class Dao_Supplier extends Dao {

	protected $_db = 'default';
	protected $_tableName = 'supplier';
	protected $_primaryKey = 'supplier_id';
	protected $_modelName = 'Model_Supplier';

	const STATE_DELETED = 0; // 状态-删除
	const STATE_ON = 1; // 状态-正常

	
	
    
    /**
     *  根据supplierId获取商品期数信息
     * @param int supplierId
     * @return Ambigous <object, mixed, number, Database_Result_Cached, multitype:>
     */
    public function getSupplierBySupplierId($supplierId){
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('supplier_id', '=', $supplierId)
    		->as_object($this->_modelName)
    		->execute();
    }
    

}
