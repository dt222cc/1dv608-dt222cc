<?php

//As of now this class handles the session variables
class LoginModel {
    
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
        if (isset($_SESSION['Message'])) {
            return $_SESSION['Message'];
        } else {
            return null;
        }
    }
}

// Read somewhere that session should be handled in the model, but later on i found out that it wasn't true.
// Anyway, I'll keep it as it is for now.