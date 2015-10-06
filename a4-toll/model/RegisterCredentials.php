<?php

//Use UserCredentials instead?
class RegisterCredentials {

    private $username;
    private $password;

    public function __construct($username, $password) {
        // htmlspecialchars($username);
        // htmlspecialchars($password);
        $this->username = $this->removeSpecialChars($username);
        $this->password = $this->removeSpecialChars($password);
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    private function removeSpecialChars($string) {
        $string = str_replace(' ', '-', $string);
        return preg_replace('/[^A-Za-z0-9\-._#&$]/', '', $string);
    }
}