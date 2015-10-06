<?php

require_once("../../data/Database.php");

class RegisterDAL {

	private static $table = "users";
	private static $usernameField = "username";
	private static $passwordField = "password";

	private $conn;
	private $stmt;

	/**
	 * Establish a connection to the database (I do not know/remember where to put the connection details, I just put them in the Settings.php)
	 */
	public function __construct() {
		// Create connection
		$this->conn = new mysqli(Database::HOST, Database::USER, Database::PASSWORD, Database::SCHEMA);
		// $this->conn = new mysqli(Settings::DB_HOST, Settings::DB_USER, Settings::DB_PASSWORD, Settings::DB_SCHEMA);

		// Check connection
		if ($this->conn->connect_error) {
		    die("Connection failed: " . $this->conn->connect_error);
		}
	}

	/**
	 * Check if the username already exists in the database
	 * @return true if user exists || else false
	 */
	public function IsFieldUnique($username) {
		$this->stmt = $this->conn->prepare("SELECT ".self::$usernameField." FROM ".self::$table." WHERE ".self::$usernameField." = ?");
		if ($this->stmt === FALSE) {
			throw new Exception($this->conn->error);
		}
		$this->stmt->bind_param('s', $username);
		$this->stmt->execute();
		$this->stmt->store_result();

		if ($this->stmt->num_rows() > 0) {
      		return true;
      	} else {
	  		return false;
      	}
	}

	/**
	 * Add username and password to the database
	 */
	public function add($username, $password) {
		$this->stmt = $this->conn->prepare("INSERT INTO ".self::$table." (".self::$usernameField.", ".self::$passwordField.") VALUES (?, ?)");
		if ($this->stmt === FALSE) {
			throw new Exception($this->conn->error);
		}
		$this->stmt->bind_param('ss', $username, $password);
		$this->stmt->execute();
	}
}