<?php

// INCLUDE THE FILES NEEDED...
require_once("../../../data/Database.php");
require_once("Settings.php");
require_once("model/DAL/QuizDAL.php");
require_once("model/Quiz.php");
require_once("model/Question.php");
require_once("model/Result.php");
require_once("view/QuizView.php");
require_once("controller/QuizController.php");

// MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
if (Settings::DISPLAY_ERRORS) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'ON');
}

// Session must be started before ..
session_start();

// Dependency injection
$dal = new QuizDAL();
$questions = $dal->loadQuiz();
$m = new Quiz($questions);
$v = new QuizView($m);
$c = new QuizController($m, $v);

$c->doControl();

// Generate output
$v->render();