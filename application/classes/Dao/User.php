<?php

/**
 * 视频信息数据访问层
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
	 * 通过视频id更新视频的信息
	 * 
	 * @param integer $videoId        	
	 * @param array $values        	
	 * @return integer
	 */
	public function updateByUserId($userId, $values) {
		return DB::update($this->_tableName)->set($values)->where($this->_primaryKey, '=', $userId)->execute();
	}

}
