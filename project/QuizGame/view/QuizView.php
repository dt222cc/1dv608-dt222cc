<?php

class QuizView
{
	const QUIZ_SETUP = "QuizView::QuizSetup";
	const QUIZ_SOLVE = "QuizView::QuizSolve";
	const THEME = "Who is the author of the following quote?";

	/** @var \model\Quiz */
	private $model;

	/** @param \model\Quiz */
	public function __construct(Quiz $quiz)
	{
		$this->model = $quiz;
	}

	/**
	 * Accessor method for play attempts by form
	 *
	 * @return boolean true if user did press play
	 */
	public function userWantsToPlay() {
		return isset($_POST[self::QUIZ_SOLVE]);
	}

	/**
	 * Genereate either the quiz setup form or the solve question form
	 *
	 * @return string HTML
     */
	public function getResponse()
	{
		// Workaround for picking correct form
		if (isset($_POST[self::QUIZ_SETUP]) == true || isset($_POST[self::QUIZ_SOLVE]) == true) {
			return $this->generateSolveQuestionFormHTML();
		} else {
			return $this->generateQuizSetupHTML();
		}
	}

	/**
	 * Some introduction and setup form for picking amount of questions to be solved.
	 *
	 * @return string HTML
	 */
	private function generateQuizSetupHTML()
	{

		return "
			<div>
				<p>This quiz is about matching the following question with the correct solution, duh.. it's a quiz.</p>
				<p>There will be 3 possible solutions but only one of them is correct.</p>
				<p>Your task will be picking the correct solution with no outside help.</p>
				<p>The theme of this Quiz is \"quotes\". Match the following quotes with the correct author.</p>
			</div>

			<form method='post'>
				<b>Pick the amount of questions.</b>
				<input type='radio' name='id' value='1'> 5
				<input type='radio' name='id' value='2'> 10
				<input type='radio' name='id' value='3'> 15
				<input type='radio' name='id' value='4'> 20
				<br><br>
				<input type='submit' name='".self::QUIZ_SETUP."' value='Submit'/>
			</form>
		";
	}

	/**
	 * Generate form for solving the current question. Answers have a randomized order. The solution is the default 0 index
	 *
	 * @return string HTML
	 */
	private function generateSolveQuestionFormHTML()
	{
		$question = $this->model->getQuestion();
		$solutions = $question->getSolutions();

		// Tests
		$shuffledSolutions = $solutions;
		shuffle($shuffledSolutions);

		print_r($solutions);
		print_r($shuffledSolutions);

		$solutionsHTML = "";

		// Generate the solutions for the current question
		foreach ($shuffledSolutions as $id => $solution) {
			$solutionsHTML .= "<input type='radio' name='id' value='".$id."'> ".$solution."<br>";
		}

		return "<form method='post'>
				<b>".self::THEME."</b>
				<p>".$question->getQuestion()."</p>
				".$solutionsHTML."
				<br>
				<input type='submit' name='".self::QUIZ_SOLVE."' value='Submit'/>
			</form>
		";
	}
}