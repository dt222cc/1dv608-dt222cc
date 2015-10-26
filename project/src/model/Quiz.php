<?php

class Quiz
{
    const MYQUESTIONS = 'Quiz::MyQuestions';
    const TOTALQUESTIONS = 'Quiz::TotalQuestions';
    const CURRENT_QUESTION = 'Quiz::CurrentQuestion';
    const CORRECT = 'Quiz::Correct';
    const INCORRECT = 'Quiz::Incorrect';

    const CORRECT_SOLUTION_INDEX = 0;

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

        // Retrieve questions from the database
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
        return $this->getQuestions()[$this->getCurrentQuestionId()];
    }

    /**
     * @param string
     * @return bool
     */
    public function checkSolution($solutionToValidate)
    {
        return $this->getQuestion()->isCorrect($solutionToValidate);
    }

    /** @return bool */
    public function isOver()
    {
        return $this->getCurrentQuestionId() == $this->getTotalQuestions();
    }

    /** @return Result */
    public function getResult()
    {
        return new Result($this->getTotalCorrect(), $this->getTotalIncorrect());
    }

    /** @param bool */
    public function updateResults($isCorrect)
    {
        $_SESSION[self::CURRENT_QUESTION] = $this->getCurrentQuestionId() + 1;

        if ($isCorrect) {
            $_SESSION[self::CORRECT] += 1;
        } else {
            $_SESSION[self::INCORRECT] += 1;
        }
    }

    /**
     * @param Question
     * @return bool
     */
    public function addNewQuestionToDatabase(Question $questionToAdd)
    {
        $quizDAL = new QuizDAL();
        return $quizDAL->saveQuestion($questionToAdd);
    }

    /** @return int */
    public function getCorrectSolutionIndex()
    {
        return self::CORRECT_SOLUTION_INDEX;
    }

    /** @return Question[] */
    private function getQuestions()
    {
        return $_SESSION[self::MYQUESTIONS];
    }

    /** @return int */
    private function getCurrentQuestionId()
    {
        return intval($_SESSION[self::CURRENT_QUESTION]);
    }

    /**  @return int */
    private function getTotalQuestions()
    {
        return intval($_SESSION[self::TOTALQUESTIONS]);
    }

    /** @return int */
    private function getTotalCorrect()
    {
        return intval($_SESSION[self::CORRECT]);
    }

    /** @return int */
    private function getTotalIncorrect()
    {
        return intval($_SESSION[self::INCORRECT]);
    }
}