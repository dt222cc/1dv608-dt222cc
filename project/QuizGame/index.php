<?php

// INCLUDE THE FILES NEEDED...
require_once("../../../data/Database.php");
require_once("Settings.php");
require_once("model/DAL/QuizDAL.php");
require_once("model/Quiz.php");
require_once("model/Question.php");
require_once("model/Result.php");
require_once("view/QuizView.php");
require_once("view/LayoutView.php");
require_once("controller/QuizController.php");

// MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
if (Settings::DISPLAY_ERRORS) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'ON');
}

// SESSION MUST BE STARTED BEFORE ..
session_start();

// DEPENDENCY INJECTIONS
$dal = new QuizDAL();
$m = new Quiz($dal->getQuestions());
$v = new QuizView($m);
$c = new QuizController($m, $v);

// 
$c->doControl();

// GENERATE OUTPUT
$lv = new LayoutView();
$lv->render($v);