<?php
class Slice_DB_Time_Month extends Slice_DB {
	
	public function route() {
		return $this->_name.'_'.date('m', $this->_key);
	}
}