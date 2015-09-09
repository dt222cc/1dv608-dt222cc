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
$v = new \view\LoginView();
$dtv = new \view\DateTimeView();
$lv = new \view\LayoutView();
$login = new \controller\Login();

//SESSION
session_start();
if (!isset($_SESSION['IsLoggedIn'])) {
    $_SESSION['IsLoggedIn'] = false;
}

$message = "";

/**
* If user just submitted a login form or pressed logout button
* @param LoginView::UserName & LoginView::Password, Data from form
* @return void, BUT writes the response message from the results
*/
if (isset($_POST["LoginView::Login"])) {
    if (empty($_POST["LoginView::UserName"])) {
        $message = "Username is missing";
    } elseif (empty($_POST["LoginView::Password"])) {
        $message = "Password is missing";
    } elseif ($_POST["LoginView::UserName"] == "Admin" && $_POST["LoginView::Password"] == "Password") {
        $message = "Welcome";
        $_SESSION['IsLoggedIn'] = true;
    } else {
        $message = "Wrong name or password";
    }
} elseif (isset($_POST["LoginView::Logout"])) {
    $message = "Bye bye!";
    $_SESSION['IsLoggedIn'] = false;
}

// $login->doLogin();

//RENDER VIEWS
$lv->render($_SESSION['IsLoggedIn'], $v, $dtv, $message);
// $lv->render($_SESSION['IsLoggedIn'], $v, $dtv, $login->getMessage());
// $lv->render(false, $v, $dtv);
