<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('controller/LoginController.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//SESSION
session_start();

//Should be refactored? as part of model? 
if (!isset($_SESSION['IsLoggedIn']) && !isset($_SESSION['Feedback'])) {
    $_SESSION['IsLoggedIn'] = false;
    $_SESSION['Feedback'] = "";
}

//CREATE OBJECTS OF THE VIEWS/CONTROLLERS
$v = new LoginView();
$dtv = new DateTimeView();
$lv = new LayoutView();

$lc = new LoginController();

//Can only login when logged out and vice versa
if (!$_SESSION['IsLoggedIn']) {
    if (isset($_POST['LoginView::Login'])) {
       $lc->doLogin();
    }
}
else {
    if (isset($_POST['LoginView::Logout'])) {
        $lc->doLogout();
    }
}

//RENDER VIEWS
$lv->render($_SESSION['IsLoggedIn'], $v, $dtv);