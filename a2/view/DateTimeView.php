<?php

class DateTimeView {
	
	private $timeZone;
	private $timeString;
	
	public function __construct() {
		$this->timeZone = date_default_timezone_set('Europe/Stockholm');
		$this->timeString = date("l") . ", the " . date("jS") . " of " . date("F Y") . ", The time is " . date("H:i:s");
	}
	
	public function show() {
		return '<p>' . $this->timeString . '</p>';
	}
}