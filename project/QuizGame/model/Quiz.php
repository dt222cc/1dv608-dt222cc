<?php

class Quiz
{
    const CURRENT_QUESTION = 'Quiz::CurrentQuestion';
    const CORRECT = 'Quiz::Correct';
    const INCORRECT = 'Quiz::Incorrect';

    /** @var string[] */
    private $questions;

    /**
     * Initiate/Setting up the game (sessions and stuff)
     *
     * @param Question[] $questions
     */
    public function __construct(array $questions)
    {
        $this->questions = $questions;

        // Move these later
        $_SESSION[self::CURRENT_QUESTION] = 0;
        $_SESSION[self::CORRECT] = 0;
        $_SESSION[self::INCORRECT] = 0;
    }

    /**
     * Initiate/Setting up the game (sessions and stuff)
     */
    public function startQuiz()
    {
        // $_SESSION[self::CURRENT_QUESTION] = 0;
        // $_SESSION[self::CORRECT] = 0;
        // $_SESSION[self::INCORRECT] = 0;
    }

    /**
     * Get the next question in the list
     *
     * @return Question
     */
    public function getQuestion()
    {
        $currentQuestion = $this->getCurrentQuestionId();

        return $this->questions[$currentQuestion];
    }

    /**
     * @param int
     * @return bool
     */
    public function checkSolution($id)
    {
        // Check if correct
        // Add result to results
        // After checking the solution, the counter increases by one
        $_SESSION[self::CURRENT_QUESTION] = $this->getCurrentQuestionId() + 1;
    }

    /**
     * Game is over when there is no more questions left
     *
     * @return bool
     */
    public function isOver()
    {
        return false;
    }

    /**
     * Get the result when the game is over
     *
     * @return Result
     */
    public function getResult()
    {

    }

    /**
     * Add the result to session variable Correct/Incorrect after each answer
     *
     * @param bool
     */
    private function addResult($isCorrect)
    {
        if ($isCorrect)
        {
            $_SESSION[self::CORRECT] += 1;
        }
        else
        {
            $_SESSION[self::INCORRECT] += 1;
        }
    }

    /**
     * The idea is that we use the session variable to check which question we are at.
     *
     * @return Result
     */
    private function getCurrentQuestionId()
    {
        return $_SESSION[self::CURRENT_QUESTION];
    }
}