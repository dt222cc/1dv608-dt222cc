<?php

require_once("controller/LoginController.php");
require_once("controller/RegisterController.php");
require_once("model/LoginModel.php");
require_once("model/RegisterModel.php");
require_once("view/LoginView.php");
require_once("view/RegisterView.php");
require_once("view/DateTimeView.php");
require_once("view/LayoutView.php");
require_once("view/RegisterView.php");

class MasterController {

	private $login;
	private $loginModel;
	private $loginView;
	private $register;
	private $registerModel;
	private $registerView;
	private $dtv;
	private $lv;
	private $v;

	// Dependency injection
  	public function __construct() {
		$this->loginModel = new LoginModel();
		$this->loginView = new LoginView($this->loginModel);
		$this->login = new LoginController($this->loginModel, $this->loginView);

		$this->registerModel = new RegisterModel();
		$this->registerView = new RegisterView();
		$this->register = new RegisterController($this->registerModel, $this->registerView);
  	}

	// Check URL to determinated what control to use
	public function doControl() {
		if (isset($_GET["register"]) == false) {
			$this->login->doControl();
		}
		$this->register->doControl();
	}

	// Generate output
	public function renderHTML() {
		$this->dtv = new DateTimeView();
		$this->lv = new LayoutView();
		$this->lv->render($this->loginModel->isLoggedIn($this->loginView->getUserClient()), $this->loginView, $this->registerView, $this->dtv);
	}
}