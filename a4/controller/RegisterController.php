<?php

require_once("model/RegisterModel.php");
require_once("view/RegisterView.php");

require_once('exceptions/UserAlreadyExistsException.php');

class RegisterController {

	private $model;
	private $view;

	public function __construct(RegisterModel $model, RegisterView $view) {
		$this->model = $model;
		$this->view =  $view;
	}

	public function doControl() {
		try {
			if ($this->view->userWantsToRegister() === true) {
				if ($this->view->validateRegisterForm() === true) {
					$credentials = $this->view->getRegisterCredentials();
					if ($this->model->doRegister($credentials) === true) {
						$this->view->setRegisterSucceeded();
					}
				}
			}
		}
		// If user already exists, display the correct message
		catch (UserAlreadyExistsException $e) {
			$this->view->setUserAlreadyExists();
		}
	}
}