<?php

require_once("UserCredentials.php");
require_once("TempCredentials.php");
require_once("TempCredentialsDAL.php");
require_once("LoggedInUser.php");
require_once("UserClient.php");
require_once("DatabaseConnection.php");

class LoginModel {

	//TODO: Remove static to enable several sessions
	private static $sessionUserLocation = "LoginModel::loggedInUser";

	/**
	 * @var null | TempCredentials
	 */
	private $tempCredentials = null;

	private $tempDAL;

	public function __construct() {
		self::$sessionUserLocation .= Settings::APP_SESSION_NAME;

		if (!isset($_SESSION)) {
			//Alternate check with newer PHP
			//if (\session_status() == PHP_SESSION_NONE) {
			assert("No session started");
		}
		$this->tempDAL = new TempCredentialsDAL();
	}

	/**
	 * Checks if user is logged in
	 * @param  UserClient $userClient The current calls Client
	 * @return boolean                true if user is logged in.
	 */
	public function isLoggedIn(UserClient $userClient) {
		if (isset($_SESSION[self::$sessionUserLocation])) {
			$user = $_SESSION[self::$sessionUserLocation];

			if ($user->sameAsLastTime($userClient) == false) {
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * Attempts to authenticate
	 */
	public function doLogin(UserCredentials $uc) {
		$this->tempCredentials = $this->tempDAL->load($uc->getName());

		$loginByUsernameAndPassword = $this->authenticate($uc->getName(), $uc->getPassword());
		$loginByTemporaryCredentials = $this->tempCredentials != null && $this->tempCredentials->isValid($uc->getTempPassword());
		$loginByAdmin = Settings::USERNAME === $uc->getName() && Settings::PASSWORD === $uc->getPassword();

		if ($loginByUsernameAndPassword || $loginByTemporaryCredentials || $loginByAdmin) {
			$user = new LoggedInUser($uc); 

			$_SESSION[self::$sessionUserLocation] = $user;

			return true;
		}
		return false;
	}

	public function doLogout() {
		unset($_SESSION[self::$sessionUserLocation]);
	}

	/**
	 * @return TempCredentials
	 */
	public function getTempCredentials() {
		return $this->tempCredentials;
	}

	/**
	 * renew the temporary credentials
	 */
	public function renew(UserClient $userClient) {
		if ($this->isLoggedIn($userClient)) {
			$user = $_SESSION[self::$sessionUserLocation];
			$this->tempCredentials = new TempCredentials($user);
			$this->tempDAL->save($user, $this->tempCredentials);
		}
	}

	/**
	 * Establish connection and see if the username and password match (fulhack)
	 */
	private function authenticate($username, $password) {
		$this->db = new DatabaseConnection();
		$results = $this->db->getUser($username);

		// This does not work in the public server. 000webhost
		if (count($results) == 2 && password_verify($password, $results[1])) {
			return true;
		} else {
			return false;
		}
	}
}