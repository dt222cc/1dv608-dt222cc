<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new LoginView();
$dtv = new DateTimeView();
$lv = new LayoutView();

//RENDER VIEWS (NOT LOGGED IN)
$lv->render(false, $v, $dtv);

//if user just submitted a login form
if (isset($_POST["LoginView::Login"])) {
    // check login form contents
    if (empty($_POST["LoginView::UserName"])) {
        $feedback = "Username is missing";
    } elseif (empty($_POST["LoginView::Password"])) {
        $feedback = "Password is missing";
    } elseif (!empty($_POST["LoginView::UserName"]) && !empty($_POST["LoginView::Password"])) {
        if ($_POST["LoginView::UserName"] == "Admin") {
            if ($_POST["LoginView::Password"] == "Password") {
               $feedback = "User exist and the password match.";
            } else {
               $feedback = "Wrong name or password";
            }
        } else {
           $feedback = "Wrong name or password";
        }
    }
    //testing purposes
    echo $feedback;
}