<?php

class QuizView
{
	const QUIZ_SETUP = "QuizView::Setup";
	const QUIZ_QUESTIONS = "QuizView::Questions";
	const QUIZ_SOLVE = "QuizView::Solve";
	const QUIZ_SOLUTION = "QuizView::RadioSolution";
	const THEME = "Who is the author of the following quote?";

    private $isOver = false;

	/** @var Quiz */
	private $model;

	/** @param Quiz */
	public function __construct(Quiz $quiz)
	{
		$this->model = $quiz;
	}

	/**
	 * Set game is over
	 */
    public function setIsOver()
    {
        $this->isOver = true;
    }

	/**
	 * Accessor methods for form submits
	 *
	 * @return boolean true if user did press submit
	 */
	public function didUserWantToPlay()
	{
		return isset($_POST[self::QUIZ_SETUP]);
	}

    public function didUserSolveAQuestion()
	{
		return isset($_POST[self::QUIZ_SOLVE]);
	}

    /**
    * Accessor method for getting the amount of questions to fetch from database
    *
    * @return int
    */
    public function getAmountOfQuestions()
    {
        return intval($_POST[self::QUIZ_QUESTIONS]);
    }

    /**
	* Accessor method for getting the user picked solution
	*
	* @return string
	*/
	public function getSolution()
	{
		return $_POST[self::QUIZ_SOLUTION];
	}

	/**
	 * Generate either the quiz setup form or the solve question form
	 *
	 * @return string HTML
     */
	public function getResponse()
	{
        if ($this->isOver) {
            return $this->generateQuizResultsHTML();
        }
		// Workaround for picking correct form
		else if (isset($_POST[self::QUIZ_SETUP]) == true || isset($_POST[self::QUIZ_SOLVE]) == true) {
			return $this->generateSolveQuestionFormHTML();
		}
		return $this->generateQuizSetupHTML();
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
			</div>

			<form method='post'>
				<b>Pick the amount of questions.</b>
				<input type='radio' name='".self::QUIZ_QUESTIONS."' value='5' checked> 5
				<input type='radio' name='".self::QUIZ_QUESTIONS."' value='10'> 10
				<input type='radio' name='".self::QUIZ_QUESTIONS."' value='15'> 15
				<input type='radio' name='".self::QUIZ_QUESTIONS."' value='20'> 20
				<br><br>
				<input type='submit' name='".self::QUIZ_SETUP."' value='Submit'/>
			</form>
		";
	}

	/**
	 * Generate form for solving the current question. Answers have a randomized order.
	 *
	 * @return string HTML
	 */
	private function generateSolveQuestionFormHTML()
	{
		$question = $this->model->getQuestion();
		$solutions = $question->getSolutions();
        shuffle($solutions);

		return "<form method='post'>
				<b>".self::THEME."</b>
				<p>".$question->getQuestion()."</p>
				<input type='radio' name='".self::QUIZ_SOLUTION."' value='".$solutions[0]."' checked>" .$solutions[0]."<br>
				<input type='radio' name='".self::QUIZ_SOLUTION."' value='".$solutions[1]."'>" .$solutions[1]."<br>
				<input type='radio' name='".self::QUIZ_SOLUTION."' value='".$solutions[2]."'>" .$solutions[2]."<br><br>
				<input type='submit' name='".self::QUIZ_SOLVE."' value='Submit'/>
			</form>
		";
	}

	/**
	 * Generate the results
	 *
	 * @return string HTML
	 */
    private function generateQuizResultsHTML()
    {
        $correct = $result->getCorrect();
        $incorrect = $result->getIncorrect();

        return "
			<div>
				<b>Your results: </b>
				<p>- Correct: ".$correct."</p>
				<p>- Incorrect: ".$incorrect."</p>
                <a href='index.php'>Play again</a>
			</div>
		";
    }
}