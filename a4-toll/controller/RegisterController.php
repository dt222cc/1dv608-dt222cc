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
					// Get the usercredentials and have them stripped of "some" special characters
					$uc = $this->view->getRegisterCredentials();
					$name = $this->view->removeSomeSpecialCharacters($uc->getUsername());
					$pw = $this->view->removeSomeSpecialCharacters($uc->getPassword());
					// If the registration was successful, redirect to login form and display the correct message
					if ($this->model->doRegister($name, $pw) === true) {
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