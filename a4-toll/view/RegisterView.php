<?php

class RegisterView {
	// These names are used in $_POST
	private static $register = "RegisterView::Register";
	private static $name = "RegisterView::UserName";
	private static $password = "RegisterView::Password";
	private static $passwordRepeat = "RegisterView::PasswordRepeat";
	private static $cookieName = "RegisterView::CookieName";
	private static $CookiePassword = "RegisterView::CookiePassword";
	private static $messageId = "RegisterView::Message";

	// For validation
	private static $minPassword = 6;
	private static $minUserName = 3;

	// View state set by controller through setters
	private $registerHasSucceeded = false;
	private $userAlreadyExists = false;

	// For redirecting to login form with a message
	private static $sessionSaveLocation = "\\view\\LoginView\\message";
	private $actualLink;

	public function __construct() {
		self::$sessionSaveLocation .= Settings::APP_SESSION_NAME;
	}

	/**
	 * Accessor method for register credentials
	 * @return model/RegisterCredentials
	 */
	public function getRegisterCredentials() {
		return new RegisterCredentials($this->getUserName(), $this->getPassword());
	}

	/**
	 * Tell the view that register succeeded/failed so that it can show correct message
	 * @return boolean
	 */
	public function setRegisterSucceeded() {
		$this->registerHasSucceeded = true;
	}

	public function setUserAlreadyExists() {
		$this->userAlreadyExists = true;
	}

	/**
	 * Checks if the form was just posted
	 * @return boolean
	 */
	public function userWantsToRegister() {
		return isset($_POST[self::$register]);
	}

	/**
	 * Remove characters that are not allowed
	 * @return string
	 */
	public function removeSomeSpecialCharacters($string) {
		// Remove HTML TAGs
		$string = strip_tags($string);
		// Only these characters are allowed, remove everything else
		return preg_replace('/[^A-Za-z0-9#._-]/', '', $string);
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
		if ($this->registerHasSucceeded === true) {
			$message = "Registered new user.";
			$this->redirect($message);
		}
		else if ($this->userAlreadyExists === true) {
			$message = "User exists, pick another username.";
		}
		else {
			if ($this->userWantsToRegister() === true) {
				if (strlen($this->getUsername()) < 3) {
					$message .= "Username has too few characters, at least 3 characters.<br>";
				}
				if (strlen($this->getPassword()) < 6) {
					$message .= "Password has too few characters, at least 6 characters.<br>";
				}
				if ($this->getPassword() !== $this->getPasswordRepeat()) {
					$message .= "Passwords do not match.<br>";
				}
				if ($this->removeSomeSpecialCharacters($this->getUsername()) !== $this->getUsername()) {
					$message .= "Username contains invalid characters.";
				}
			}
		}
		return $this->generateRegisterFormHTML($message);
	}

	/**
	 * Have to validate form data when doing the registration on the model
	 * @return boolean
	 */
	public function validateRegisterForm() {
		if (strlen($this->getUsername()) < 3 ||
			strlen($this->getPassword()) < 6 ||
			$this->getPassword() !== $this->getPasswordRepeat() ||
			$this->removeSomeSpecialCharacters($this->getUsername()) !== $this->getUsername()) {
			return false;
		} else {
			return true;
		}
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
					<input type='text' size='20' name='".self::$name."' id='".self::$name."' value='".$this->removeSomeSpecialCharacters($this->getUsername())."'/>
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

	/**
	 * Redirect to the login form with successful registration message
	 */
	private function redirect($message) {
		$_SESSION[self::$sessionSaveLocation] = $message;
		$this->actualLink = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		header("Location: $this->actualLink");
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
}