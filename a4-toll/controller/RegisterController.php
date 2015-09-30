<?php

require_once("model/RegisterModel.php");
require_once("view/RegisterView.php");

class RegisterController {

	private $model;
	private $view;

	public function __construct(RegisterModel $model, RegisterView $view) {
		$this->model = $model;
		$this->view =  $view;
	}

	public function doControl() {
		// Not sure on how to do things here, might have to do some refactoring
		// Missing lots of details for the moment (placeholders)
		if ($this->view->userWantsToRegister()) {
				if ($this->model->doRegistration() == true) {
					// $this->view->setRegistrationSucceeded();
				} else {
					// $this->view->setRegistrationFailed();
				}
			}
	}
}