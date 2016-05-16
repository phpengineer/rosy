<?php
/**
 * 日志信息model
 * @author baishen
 */
class Model_Log extends Model_BaseModel {

	public function getCreateTime($format = NULL) {
		return $format ? date($format, $this->create_time) : $this->create_time;
	}

	public function getGetArray() {
		return json_decode($this->get, true);
	}

	public function getPostArray() {
		return json_decode($this->post, true);
	}

	public function getMessage() {
		return HTML::chars($this->message);
	}
	
	public function getController() {
		return HTML::chars($this->controller);
	}

	public function getAction() {
		return HTML::chars($this->action);
	}
}
