<?php

class LayoutView
{
	public function __construct()
	{
		date_default_timezone_set("Europe/Stockholm");
	}

	/**
	 * Render the Layout
	 *
	 * @param /view/QuizView
	 */
	public function render(QuizView $qv)
	{
		echo '<!DOCTYPE html>
			<html>
			<head>
				<meta charset="utf-8">
				<title>Project MVC Quiz-Game dt222cc</title>
			</head>
			<body>
				<h1>Project MVC Quiz-Game</h1>
				<div class="container">
					' . $qv->getResponse() . '
				</div>
				</body>
			</html>
		';
	}
}