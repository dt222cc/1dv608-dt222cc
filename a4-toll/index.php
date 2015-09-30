<?php

require_once("Settings.php");
require_once("controller/MasterController.php");

if (Settings::DISPLAY_ERRORS) {
	error_reporting(-1);
	ini_set('display_errors', 'ON');
}

// Session must be started before LoginModel/RegisterModel is created
session_start(); 

// Controller must be run first since state is changed
$c = new MasterController();
$c->doControl();

// Generate output
$c->renderHTML();