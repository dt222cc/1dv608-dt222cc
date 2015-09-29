<?php

class UserClient {
	private $remoteAddr;
	private $userAgent;

	public function __construct($remoteAddr, $userAgent) {
		$this->remoteAddr = $remoteAddr;
		$this->userAgent = $userAgent;
	}

	public function isSame(UserClient $other) {
		return  $other->remoteAddr == $this->remoteAddr && 
				$other->userAgent == $this->userAgent;
	}
}