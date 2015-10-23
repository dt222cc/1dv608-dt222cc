<?php

class Quiz
{
    const MYQUESTIONS = 'Quiz::MyQuestions';
    const TOTALQUESTIONS = 'Quiz::TotalQuestions';
    const CURRENT_QUESTION = 'Quiz::CurrentQuestion';
    const CORRECT = 'Quiz::Correct';
    const INCORRECT = 'Quiz::Incorrect';

    /**
     * Initiate/Setting up the game
     *
     * @param int
     */
    public function startQuiz($totalQuestions)
    {
        // Free all sessions when starting a new quiz (To retrieve new questions)
        session_unset();

        $_SESSION[self::CURRENT_QUESTION] = 0;
        $_SESSION[self::CORRECT] = 0;
        $_SESSION[self::INCORRECT] = 0;
        $_SESSION[self::TOTALQUESTIONS] = $totalQuestions;

        // Retrieve questions from the database and store it to session
        if (!isset($_SESSION[self::MYQUESTIONS])) {
            $quizDAL = new QuizDAL();
            $questions = $quizDAL->getQuestions($totalQuestions);
            shuffle($questions);
            $_SESSION[self::MYQUESTIONS] = $questions;
        }
    }

    /**
     * Get the next question in the list
     *
     * @return Question
     */
    public function getQuestion()
    {
        return $_SESSION[self::MYQUESTIONS][$this->getCurrentQuestionId()];
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
        return $this->getCurrentQuestionId() >= $_SESSION[self::TOTALQUESTIONS];
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
     * Try to add the newly created question to the database
     *
     * @param Question
     */
    public function addNewQuestionToDatabase(Question $questionToAdd)
    {
        $quizDAL = new QuizDAL();
        return $quizDAL->saveQuestion($questionToAdd);
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