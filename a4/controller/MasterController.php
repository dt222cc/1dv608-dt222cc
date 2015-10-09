<?php

require_once("controller/LoginController.php");
require_once("controller/RegisterController.php");

class MasterController {

	private $login;
	private $register;

	public function __construct(LoginController $lc, RegisterController $rc) {
		$this->login = $lc;
		$this->register = $rc;
  	}

	// Check URL to determinated which control to use
	public function doControl() {
		if (isset($_GET["register"]) == false) {
			$this->login->doControl();
		}
		else {
			$this->register->doControl();
		}
	}
}