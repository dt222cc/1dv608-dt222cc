<?php

class Quiz
{
    const CURRENT_QUESTION = 'Quiz::CurrentQuestion';
    const CORRECT = 'Quiz::Correct';
    const INCORRECT = 'Quiz::Incorrect';
    const TOTALQUESTIONS = 'Quiz::TotalQuestions';

    /** @var QuizDAL */
    private $quizDAL;

    /** @var Question[] */
    private $questions;

    /**
     * Collect questions from database (this seems to be called after every post, because of this I cannot shuffle the questions)
     *
     * @param Question[] $questions
     */
    public function __construct()
    {
        $this->quizDAL = new QuizDAL();
        $this->questions = $this->quizDAL->getQuestions();
    }

    /**
     * Initiate/Setting up the game (reset sessions and set the limit to the total questions to be solved)
     *
     * @param int
     */
    public function startQuiz($totalQuestions)
    {
        $_SESSION[self::CURRENT_QUESTION] = 0;
        $_SESSION[self::CORRECT] = 0;
        $_SESSION[self::INCORRECT] = 0;
        $_SESSION[self::TOTALQUESTIONS] = $totalQuestions;
    }

    /**
     * Get the next question in the list
     *
     * @return Question
     */
    public function getQuestion()
    {
        return $this->questions[$this->getCurrentQuestionId()];
    }

    /**
     * Check if the given solution is correct
     *
     * @param string
     * @return bool
     */
    public function checkSolution($solutionToValidate)
    {
        return $this->getQuestion()->isCorrect($solutionToValidate);
    }

    /**
     * Game is over when the total questions threshold have been reached
     *
     * @return bool
     */
    public function isOver()
    {
        if ($this->getCurrentQuestionId() == $_SESSION[self::TOTALQUESTIONS]) {
            return true;
        }
        return false;
    }

    /**
     * Get the result when the game is over
     *
     * @return Result
     */
    public function getResult()
    {
        return new Result(intval($_SESSION[self::CORRECT]), intval($_SESSION[self::INCORRECT]));
    }

    /**
     * Add the result to session variable Correct/Incorrect after each answer
     *
     * @param bool
     */
    public function addResult($isCorrect)
    {
        $_SESSION[self::CURRENT_QUESTION] = $this->getCurrentQuestionId() + 1;

        if ($isCorrect) {
            $_SESSION[self::CORRECT] += 1;
        } else {
            $_SESSION[self::INCORRECT] += 1;
        }
    }

    /**
     * We use the session variable to check which question we are at.
     *
     * @return int
     */
    private function getCurrentQuestionId()
    {
        return intval($_SESSION[self::CURRENT_QUESTION]);
    }
}