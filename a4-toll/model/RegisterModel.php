<?php

require_once("RegisterCredentials.php");
require_once("RegisterDAL.php");

class RegisterModel {

	private $tempCredentials = null;

	/**
	 * Attempts to registrate user
	 * @param  RegisterCredentials $rc
	 * @return boolean
	 */
	public function doRegister($username, $password) {
		$this->db = new RegisterDAL();

		$isUnique = $this->db->isFieldUnique($username);

		if ($isUnique === false) {
			// Add the new user to the database with the password hashed/encrypted
			$hashed_password = crypt($password); // let the salt be automatically generated
			$this->db->add($username, $hashed_password);
			return true;
		} else {
			throw new UserAlreadyExistsException();
		}
	}
}