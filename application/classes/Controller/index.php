<?php
/**
 * hello world
 */
class Controller_Index extends Controller_Render {
	/**
	 * 播放接口
	 */
	public function action_index() {
		$this->_contentType = 'application/json';
		$this->_data = 'Hello World ';
		
	}

}
