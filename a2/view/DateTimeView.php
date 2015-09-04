<?php

class DateTimeView {
	
	private $timeZone;
	private $timeString;
	
	public function __construct() {
		$this->timeZone = date_default_timezone_set('Europe/Stockholm');
		$this->timeString = date('l, \t\h\e jS \o\f F Y, \T\h\e \t\i\m\e \i\s H:i:s');
	}
	
	public function show() {
		return '<p>' . $this->timeString . '</p>';
	}
}