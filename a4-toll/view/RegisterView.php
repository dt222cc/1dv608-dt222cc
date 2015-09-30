<?php

class RegisterView {
	// These names are used in $_POST
	private static $register = "DoRegistration";
	private static $name = "RegisterView::UserName";
	private static $password = "RegisterView::Password";
	private static $passwordRepeat = "RegisterView::PasswordRepeat";
	private static $cookieName = "RegisterView::CookieName";
	private static $CookiePassword = "RegisterView::CookiePassword";
	private static $messageId = "RegisterView::Message";

	// For validation
	private static $minPassword = 6;
	private static $minUserName = 3;

	// For redirecting to login form with a message
	private static $sessionSaveLocation = "\\view\\LoginView\\message";
	private $actualLink;

	public function __construct() {
		self::$sessionSaveLocation .= Settings::APP_SESSION_NAME;
	}

	/**
	 * Create HTTP response
	 *
	 * Should be called if user wants to register (a register attempt)
	 * Gets the correct messages 
	 * @return String HTML
	 */
	public function response() {
		$message = "";

		if ($this->userWantsToRegister()) {
			if ($this->getUserName() == "") {
				$message .= $this->getUserNameError();
				if ($this->getPassword() == "") {
					$message .= "<br>" . $this->getPasswordError();
				}
			} else if (strlen($this->getUserName()) < self::$minUserName) {
				$message .= $this->getUserNameError();
			} else if ($this->getPassword() == "" || strlen($this->getPassword()) < self::$minPassword) {
				$message .= $this->getPasswordError();
			} else if ($this->getPassword() != $this->getPasswordRepeat()) {
				$message .= $this->getMatchError();
			} else if ($this->getPassword() == $this->getPasswordRepeat()) {
				$message .= $this->getRegisteredUser();
				$this->redirect($message);
			}
			//TODO: Check if user exists, register the new user to persistence storage
		}
		return $this->generateRegisterFormHTML($message);
	}

	/**
	 * Render HTML with message
	 * @return String HTML
	 */
	private function generateRegisterFormHTML($message) {
		return "
			<h2>Register new user</h2>
			<form action='?register' form method='post' enctype='multipart/form-data'> 
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					<p id='".self::$messageId."'>$message</p>
					<label for='".self::$name."'>Username :</label>
					<input type='text' size='20' name='".self::$name."' id='".self::$name."' value='".$this->getUserName()."'/>
					<br>
					<label for='".self::$password."'>Password :</label>
					<input type='password' size='20' name='".self::$password."' id='".self::$password."'/>
					<br>
					<label for='".self::$passwordRepeat."'>Repeat password  :</label>
					<input type='password' size='20' name='".self::$passwordRepeat."' id='".self::$passwordRepeat."' />
					<br>
					<input id='submit' type='submit' name='".self::$register."' value='Register'/>
					<br>
				</fieldset>
			</form>
		";
	}

	// Redirect to the login form with successful registration message
	private function redirect($message) {
		$_SESSION[self::$sessionSaveLocation] = $message;
		$this->actualLink = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		header("Location: $this->actualLink");
	}

	/**
	 * Accessor method for register attempts by form
	 * @return boolean true if user did try to register
	 */
	public function userWantsToRegister() {
		return isset($_POST[self::$register]);
	}

	/**
	 * Accessor methods for retrieving posted data from the register form
	 * @return string
	 */
	private function getUserName() {
		if (isset($_POST[self::$name]))
			return trim($_POST[self::$name]);
		return "";
	}

	private function getPassword() {
		if (isset($_POST[self::$password]))
			return trim($_POST[self::$password]);
		return "";
	}

	private function getPasswordRepeat() {
		if (isset($_POST[self::$passwordRepeat]))
			return trim($_POST[self::$passwordRepeat]);
		return "";
	}

	/**
	 * Accessor methods for retrieving error messages.
	 * @return string
	 */
	private function getUsernameError() {
		return "Username has too few characters, at least 3 characters.";
	}

	private function getPasswordError() {
		return "Password has too few characters, at least 6 characters.";
	}

	private function getMatchError() {
		return "Passwords do not match.";
	}

	private function getUserExistsError() {
		return "User exists, pick another username.";
	}

	private function getInvalidUsernameError() {
		return "Username contains invalid characters.";
	}

	private function getRegisteredUser() {
		return "Registered new user (placeholder!).";
	}
}