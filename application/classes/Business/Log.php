<?php
/**
 * 日志数据操作接口
 */
class Business_Log extends Business {

	/**
	 * 获取一组日志
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getLogs($number = 0, $offset = 0) {
		if(!is_numeric($number) || !is_numeric($offset)) {
			return array();
		}
		return Dao::factory('Log')->getLogs($number, $offset);
	}

	/**
	 * 根据关键字获取一组日志
	 * @param string $keyword
	 * @param integer $offset
	 * @param integer $number
	 * @return array
	 */
	public function getLogsByKeyword($keyword, $number = 0, $offset = 0) {
		if(!is_numeric($number) || !is_numeric($offset)) {
			return array();
		}
		return Dao::factory('Log')->getLogsByKeyword($keyword, $number, $offset);
	}

	/**
	 * 获取一组日志的数量
	 * @return integer
	 */
	public function countLog() {
		return Dao::factory('Log')->countLog();
	}

	/**
	 * 根据关键字获取一组日志的数量
	 * @param string $keyword
	 * @return integer
	 */
	public function countLogByKeyword($keyword = '') {
		return Dao::factory('Log')->countLogByKeyword($keyword);
	}
	
	/**
	 * 获得日志列表分页
	 * @param string $keyword
	 * @param number $page
	 * @param number $size
	 * @param string $key
	 */
	public function getPagination($keyword = '', $page = 1, $size = 1, $key = 'page') {
		if($keyword) {
			$count = Dao::factory('Log')->countLogByKeyword($keyword);
		} else {
			$count = Dao::factory('Log')->countLog();
		}
		
		return Pagination::factory()
		->total($count)
		->number($size)
		->key($key)
		->execute();
	}
	
	public function getLogList($keyword = '', $number = 0, $offset = 0) {
		if($keyword) {
			$logs = Dao::factory('Log')->getLogsByKeyword($keyword, $number, $offset);
		} else {
			$logs = Dao::factory('Log')->getLogs($number, $offset);
		}
		
		return $logs;
	}
	
}
