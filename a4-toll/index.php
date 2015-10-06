<?php

require_once("Settings.php");
require_once("controller/MasterController.php");
require_once("view/DateTimeView.php");
require_once("view/LayoutView.php");

if (Settings::DISPLAY_ERRORS) {
	error_reporting(-1);
	ini_set('display_errors', 'ON');
}

//Session must be started before LoginModel/RegisterModel is created
session_start(); 

//Dependency injection
$lm = new LoginModel();
$lv = new LoginView($lm);
$lc = new LoginController($lm, $lv);

$rm = new RegisterModel();
$rv = new RegisterView();
$rc = new RegisterController($rm, $rv);

//Controller must be run first since state is changed
$c = new MasterController($lc, $rc);
$c->doControl();

//Generate output
$dtv = new DateTimeView();
$v = new LayoutView();
$v->render($lm->isLoggedIn($lv->getUserClient()), $lv, $rv, $dtv);