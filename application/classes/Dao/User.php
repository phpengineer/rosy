<?php

/**
 * 用户信息数据访问层
 * @author renhai
 */
class Dao_User extends Dao {

	protected $_db = 'default';
	protected $_tableName = 'user';
	protected $_primaryKey = 'id';
	protected $_modelName = 'Model_User';

	const STATUS_DELETED = - 1; // 状态-删除
	const STATUS_OFF = 0; // 状态-正常

	/**
	 * 插入一条用户信息
	 * @param array $values
	 * @return Ambigous <object, mixed, number, Database_Result_Cached, multitype:>
	 */
	public function insert(array $values) {
		return DB::insert($this->_tableName)
				->columns(array_keys($values))
				->values(array_values($values))
				->execute();
	}
	
	/**
	 * 根据user_id获取用户信息
	 * @param integer $userId
	 * @return Ambigous <object, mixed, number, Database_Result_Cached, multitype:>
	 */
	public function delete($userId) {
		return DB::update($this->_tableName)
				->set(array('status' => self::STATUS_DELETED))
				->where($this->_primaryKey, '=', $userId)
				->execute();
	}
	
    
    /**
     * 通过user_id更新用户的信息
     *
     * @param integer $userId
     * @param array $values
     * @return integer
     */
    public function updateByUserId($userId, $values) {
    	return DB::update($this->_tableName)
    			->set($values)
    			->where($this->_primaryKey, '=', $userId)
    			->execute();
    }
    
    /**
     * 根据user_id获取用户信息
     * @param integer $userId
     * @return Ambigous <object, mixed, number, Database_Result_Cached, multitype:>
     */
    public function getUserByUserId($userId) {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where($this->_primaryKey, '=', $userId)
    		->as_object($this->_modelName)
    		->execute();
    }
    
    /**
     * 根据mobile获取用户信息
     */
    public function getUserByUserId($mobile) {
    	return DB::select('*')
    		->from($this->_tableName)
    		->where('mobile', '=', $mobile)
    		->as_object($this->_modelName)
    		->execute();
    }

}