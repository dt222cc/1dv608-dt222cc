<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('controller/Login.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$dtv = new DateTimeView();
$lv = new LayoutView();
// $login = new Login();

//SESSION
session_start();

if (!isset($_SESSION['IsLoggedIn']) && !isset($_SESSION['Feedback'])) {
    $_SESSION['IsLoggedIn'] = false;
    $_SESSION['Feedback'] = "";
}

/**
* If user just submitted a login form or pressed logout button
* @param LoginView::UserName & LoginView::Password, Data from form
* @return void, BUT writes the response message from the results
*/
if (isset($_POST["LoginView::Login"])) {
    if (empty($_POST["LoginView::UserName"])) {
        $_SESSION["Feedback"] = "Username is missing";
    } elseif (empty($_POST["LoginView::Password"])) {
        $_SESSION["Feedback"] = "Password is missing";
    } elseif ($_POST["LoginView::UserName"] == "Admin" && $_POST["LoginView::Password"] == "Password") {
        $_SESSION["Feedback"] = "Welcome";
        $_SESSION['IsLoggedIn'] = true;
        header('location: /portfolio/1dv608-a2/index.php'); //public
        // header('location: /a2/index.php'); //c9
        exit(); //conflict with auto test app?
    } else {
        $_SESSION["Feedback"] = "Wrong name or password";
    }
} elseif (isset($_POST["LoginView::Logout"])) {
    $_SESSION["Feedback"] = "Bye bye!";
    $_SESSION['IsLoggedIn'] = false;
    header('location: /portfolio/1dv608-a2/index.php'); //public
    // header('location: /a2/index.php'); //c9
    exit(); //conflict with auto test app?
}

//RENDER VIEWS
$lv->render($_SESSION['IsLoggedIn'], $v, $dtv);