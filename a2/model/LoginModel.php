<?php

//As of now this class handles the session variables
class LoginModel {
    
    /**
     * Location for Redirect, have one for the local(cloud9) server and another for the public server
     */
    private static $headerLocation = "location: /a2/index.php"; //c9 (local)
    // private static $headerLocation = "location: /portfolio/1dv608-a2/index.php"; //public
    
    public function __construct() {
        session_start();
        
        //Setup sessions for first visit
        if (!isset($_SESSION['IsLoggedIn']) && !isset($_SESSION['Message'])) {
            $_SESSION['IsLoggedIn'] = false;
            $_SESSION['Message'] = ""; //Still null/unset?
        }
    }
    
    public function toggleIsLoggedIn() {
        if ($_SESSION['IsLoggedIn'])
            $_SESSION['IsLoggedIn'] = false;
        else 
            $_SESSION['IsLoggedIn'] = true;
    }
    
    public function changeMessage($string) {
        $_SESSION['Message'] = $string;
    }
    
    public function getIsLoggedIn() {
        return $_SESSION['IsLoggedIn'];
    }
    
    public function getMessage() {
        if (!isset($_SESSION['Message'])) {
            return null;
        } else {
            return $_SESSION['Message'];
        }
    }
    
    public function getHeaderLocation() {
        return self::$headerLocation;
    }
}