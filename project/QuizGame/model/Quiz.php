<?php

class Quiz
{
    /** @var string[] */
    private $questions;

    /**
     * @param Question[] $questions
     */
    public function __construct(array $questions)
    {
        $this->questions = $questions;
    }

    /**
     * Initiate/Setting up the game (sessions and stuff)
     */
    public function startQuiz()
    {

    }

    /**
     * Get the next question in the list
     *
     * @return Question
     */
    public function getQuestion()
    {
		return $this->questions[0];
    }

    /**
     * @param int
     * @return bool
     */
    public function checkSolution($id)
    {

    }

    /**
     * Game is over when there is no more questions left
     *
     * @return bool
     */
    public function isOver()
    {

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

    }
}
