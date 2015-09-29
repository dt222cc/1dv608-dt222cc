<?php

class RegisterView {
	/**
	 * These names are used in $_POST
	 * @var string
	 */
	private static $register = "DoRegistration";
	private static $name = "RegisterView::UserName";
	private static $password = "RegisterView::Password";
	private static $passwordRepeat = "RegisterView::PasswordRepeat";
	private static $cookieName = "RegisterView::CookieName";
	private static $CookiePassword = "RegisterView::CookiePassword";
	private static $messageId = "RegisterView::Message";
	
	/**
	 * Create HTTP response
	 *
	 * Should be called if user wants to register (a register attempt)
	 * @return String HTML
	 */
	public function response() {
		$message = "";

		return $this->generateRegisterFormHTML($message);
	}

	/**
	 * @return String HTML
	 */
	private function generateRegisterFormHTML($message) {
		return "
			<h2>Register new user</h2>
			<form method='post' form action='?register' enctype='multipart/form-data'> 
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					<p id='".self::$messageId."'>$message</p>
					<label for='".self::$name."'>Username :</label>
					<input type='text' id='".self::$name."' name='".self::$name."' value=''/>
					<br>
					<label for='".self::$password."'>Password :</label>
					<input type='password' id='".self::$password."' name='".self::$password."'/>
					<br>
					<label for='".self::$passwordRepeat."'>Repeat password  :</label>
					<input type='password' id='".self::$passwordRepeat."' name='".self::$passwordRepeat."'/>
					<br>
					<input id='submit' type='submit' name='".self::$register."' value='Register'/>
					<br>
				</fieldset>
			</form>
		";
	}
}