<?php

class DateTimeView {

	public function show() {
		/*
		 * http://php.net/manual/en/function.date.php
		 * day, day2, monthAndYear, currentTime
		 */
		$timeString = date("l") . ", the " . date("jS") . " of " . date("F Y") . ", The time is " . date("H:i:s");

		return '<p>' . $timeString . '</p>';
	}
}