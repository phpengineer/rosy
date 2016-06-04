<?php

/**
 * 商品分类数据访问层
 * @author renhai
 */
class Dao_Category extends Dao {

	protected $_db = 'default';
	protected $_tableName = 'category';
	protected $_primaryKey = 'id';
	protected $_modelName = 'Model_Category';

	const STATUS_DELETED = 0; // 状态-删除
	const STATUS_ON = 1; // 状态-正常
	const DISPLAY_OFF = 0;//off diplay
	const DISPLAY_ON = 1;//on display

	
	
    
    /**
     *  获取商品分类信息
     * @param 
     * @return Ambigous <object, mixed, number, Database_Result_Cached, multitype:>
     */
    public function getGoodsCategory() {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('status', '=', self::STATUS_ON)
    		->and_where('display', '=', self::DISPLAY_ON)
    		->order_by('sort', 'ASC')
    		->as_object($this->_modelName)
    		->execute();
    }
    

}
