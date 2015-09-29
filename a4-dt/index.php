<?php

//INCLUDE THE FILES NEEDED...
require_once('model/LoginModel.php');

require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

require_once('controller/LoginController.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE MODELS/CONTROLLERS
$lModel = new LoginModel();

$lc = new LoginController($lModel);

//PREPARE LOGIN/LOGOUT FORM
$lc->doLogin();

//RENDER VIEWS
$lc->getHTML();