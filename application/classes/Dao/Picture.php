<?php

/**
 * 商品图片数据访问层
 * @author renhai
 */
class Dao_Picture extends Dao {

	protected $_db = 'default';
	protected $_tableName = 'picture';
	protected $_primaryKey = 'id';
	protected $_modelName = 'Model_Picture';

	const STATUS_DELETED = 0; // 状态-删除
	const STATUS_ON = 1; // 状态-正常

	
	
    
    /**
     *  获取商品分类信息
     * @param int coverId
     * @return Ambigous <object, mixed, number, Database_Result_Cached, multitype:>
     */
    public function getPictureByCoverId($coverId) {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('status', '=', self::STATUS_ON)
    		->and_where('id', '=', $coverId)
    		->as_object($this->_modelName)
    		->execute();
    }
    

}
