<?php

require_once("RegisterCredentials.php");
require_once("DatabaseConnection.php");

class RegisterModel {

	public static $newUsername = "RegisterModel::newUsername";

	/**
	 * Attempts to registrate user
	 * @param  RegisterCredentials $rc
	 * @return boolean
	 */
	public function doRegister($rc) {
		$username = $rc->getUsername();
		$password = $rc->getPassword();

		$this->db = new DatabaseConnection();
		$results = $this->db->getUser($username);

		if (count($results) == 0) {
            $password = password_hash($password, PASSWORD_BCRYPT);
			$this->db->add($username, $password);
			// Store the new username to session for loginview to retrieve
			$_SESSION[self::$newUsername] = $username;
			return true;
		} else {
			throw new UserAlreadyExistsException();
		}
	}
}