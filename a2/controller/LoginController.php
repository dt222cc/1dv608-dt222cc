<?php

class LoginController {
    
    // private static $headerLocation = "location: /a2/index.php"; //c9 (local)
    private static $headerLocation = "location: /portfolio/1dv608-a2/index.php"; //public
    
    public function __construct() {
        
    }
    
    /**
    * If user just submitted a login form
    * @param LoginView::UserName & LoginView::Password, Data from login form
    * @return void, BUT writes the response message from the results
    */
    public function doLogin() {
        if (empty($_POST['LoginView::UserName'])) {
            $_SESSION['FeedBack'] = "Username is missing";
        } elseif (empty($_POST['LoginView::Password'])) {
            $_SESSION['FeedBack'] = "Password is missing";
        } elseif ($_POST['LoginView::UserName'] == "Admin" && $_POST['LoginView::Password'] == "Password") {
            $_SESSION['FeedBack'] = "Welcome";
            $_SESSION['IsLoggedIn'] = true;
            header(self::$headerLocation);
            //exit(); //for manual test (Welcome text missing)
        } else {
            $_SESSION['FeedBack'] = "Wrong name or password";
        }
    }
    
    /**
    * If user just submitted a logout form
    * @return void, BUT writes the response message from logging out and set status as logged out
    */
    public function doLogout() {
        $_SESSION['FeedBack'] = "Bye bye!";
        $_SESSION['IsLoggedIn'] = false;
        header(self::$headerLocation);
        //exit(); //for manual test (Bye bye! text missing)
    }
}