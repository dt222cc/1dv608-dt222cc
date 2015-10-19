<?php

class QuizView
{
	/** @var \model\Quiz */
	private $model;

	/** @param \model\Quiz */
	public function __construct(Quiz $quiz)
	{
		$this->model = $quiz;
	}

	/**
	 * Render the Quiz
	 */
	public function render()
	{
		date_default_timezone_set("Europe/Stockholm");

		echo '<!DOCTYPE html>
			<html>
			<head>
				<meta charset="utf-8">
				<title>Project MVC Quiz-Game dt222cc</title>
			</head>
			<body>
				<h1>Project MVC Quiz-Game</h1>
				<div class="container">
					' . $this->getResponse() . '
				</div>
				</body>
			</html>
		';
	}


	/**
	 * TODO: Quiz start page || or the question form
	 * Handle with session or perhaps url
	 *
	 * @return string HTML
     */
	private function getResponse()
	{
		return $this->renderSolveQuestion();
	}

	/** @return string HTML */
	private function renderStartQuiz()
	{
		/**
		 * Somekind of introduction
		 */
	}

	/** @return string HTML */
	private function renderSolveQuestion()
	{
		/**
		 * Build some kind of quiz form
		 * Randomize array to solve (solution is the 0 index)
		 */

		// Testing how to retrieve the question
		$question = $this->model->getQuestion();

		$questionName = $question->getQuestion();
		$solutions = $question->getSolutions();
		return '
			<p>'.$questionName.'</p>
			<p>'.$solutions[0].'</p>
			<p>'.$solutions[1].'</p>
			<p>'.$solutions[2].'</p>
		';
	}
}