<?php
/**
 * hello world
 */
class Controller_index extends Controller_Render {

	protected $_layout = 'layouts/video';
	protected $_checkLogin = false;

	/**
	 * 播放接口
	 */
	public function action_index() {
		$this->_contentType = 'application/json';
		$this->_data = 'Hello World ';
		
	}

}
