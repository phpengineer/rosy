<?php
/**
 * 异常日志信息model
 * @author baishen
 */
class Model_Crash extends Model_BaseModel {

	public function getCreateTime($format = NULL) {
		return $format ? date($format, $this->create_time) : $this->create_time;
	}

	public function getLevel() {
		switch($this->level) {
			case LOG_EMERG:
				return '<span class="label label-danger">EMERGENCY</span>';
				break;
			case LOG_ALERT:
				return '<span class="label label-danger">ALERT</span>';
				break;
			case LOG_CRIT:
				return '<span class="label label-danger">CRITICAL</span>';
				break;
			case LOG_ERR:
				return '<span class="label label-warning">ERROR</span>';
				break;
			case LOG_WARNING:
				return '<span class="label label-warning">WARNING</span>';
				break;
			case LOG_NOTICE:
				return '<span class="label label-info">NOTICE</span>';
				break;
			case LOG_INFO:
				return '<span class="label label-info">INFO</span>';
				break;
			case LOG_DEBUG:
				return '<span class="label label-info">DEBUG</span>';
				break;
			default:
				return '';
		}
	}

	public function getFile() {
		return HTML::chars($this->file);
	}

	public function getLine() {
		return HTML::chars($this->line);
	}

	public function getMessage() {
		return HTML::chars($this->message);
	}
}
