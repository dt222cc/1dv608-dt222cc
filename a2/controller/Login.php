<?php

namespace controller;

class Login {
    
    private $message;
    
    public function __construct() {
        $this->message = "";
    }
    
    /**
    * If user just submitted a login form or pressed logout button
    * @param LoginView::UserName & LoginView::Password, Data from form
    * @return void, BUT writes the response message from the results
    */
    public function doLogin() {
        if (isset($_POST["LoginView::Login"])) {
            if (empty($_POST["LoginView::UserName"])) {
                $this->message = "Username is missing";
            } elseif (empty($_POST["LoginView::Password"])) {
                $this->message = "Password is missing";
            } elseif ($_POST["LoginView::UserName"] == "Admin" && $_POST["LoginView::Password"] == "Password") {
                $this->message = "Welcome";
                $_SESSION['IsLoggedIn'] = true;
            } else {
                $this->message = "Wrong name or password";
            }
        } elseif (isset($_POST["LoginView::Logout"])) {
            $this->message = "Bye bye!";
            $_SESSION['IsLoggedIn'] = false;
        }
    }
    
    public function getMessage() {
        return $this->message;
    }
}

//Note: Users class, for-loop 