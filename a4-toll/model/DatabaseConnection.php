<?php

require_once("../../data/Database.php");

class DatabaseConnection {

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
	public function getUser($username) {
		$this->stmt = $this->conn->prepare("SELECT ".self::$usernameField.", ".self::$passwordField." FROM ".self::$table." WHERE ".self::$usernameField." = ?");
		if ($this->stmt === FALSE) {
			throw new Exception($this->conn->error);
		}
		$this->stmt->bind_param('s', $username);
		$this->stmt->execute();
	    $this->stmt->bind_result($name, $pass);
		$this->stmt->store_result();

		// Fulhack
		if ($this->stmt->num_rows() == 1) {
			$this->stmt->fetch();
			return [$name, $pass];
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