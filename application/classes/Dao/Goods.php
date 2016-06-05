<?php

/**
 * 商品分类数据访问层
 * @author renhai
 */
class Dao_Goods extends Dao {

	protected $_db = 'default';
	protected $_tableName = 'shop';
	protected $_primaryKey = 'id';
	protected $_modelName = 'Model_Goods';

	const STATUS_DELETED = 0; // 状态-删除
	const STATUS_ON = 1; // 状态-正常
	const DISPLAY_OFF = 0;//off diplay
	const DISPLAY_ON = 1;//on display

	
	
    
    /**
     *  获取商品分类信息
     * @param int categoryId
     * @param int pageSize    每页个数
     * @param int offset  页数
     * @return Ambigous <object, mixed, number, Database_Result_Cached, multitype:>
     */
    public function getGoodsCategoryId($categoryId, $pageSize, $offset) {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('status', '=', self::STATUS_ON)
    		->and_where('display', '=', self::DISPLAY_ON)
    		->and_where('category', '=', $categoryId)
    		->order_by('hits', 'DESC')
    		->offset(($offset>1 ? ($offset-1)*$pageSize : 0))
			->limit($pageSize)
    		->as_object($this->_modelName)
    		->execute();
    }
    

}
