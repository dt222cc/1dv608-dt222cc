<?php

require_once("Gamer.php");
require_once("Game.php");
require_once("GameView.php");

$olle = new Gamer("ollie", "dMan@dmail.dru", "Dev Couch", "DC");
$view = new GameView($olle);


$olle->add(new Game("World of Wizardry", "Bluzzard", 64000));
$olle->add(new Game("Diabolo III", "Bluzzard", 64));
$olle->add(new Game("Goat Simulator", "Coffee Stain Studios", 1));



?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf8'>
		<title>$this->title</title>
	</head>
	<body>
		<?php
		$view->show();
		?>
	</body>
</html>