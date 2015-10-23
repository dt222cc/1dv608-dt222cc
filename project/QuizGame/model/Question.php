<?php

/** Question entity */
class Question
{
    // private $id;
    private $question;
    private $solutions;
    private $correctIndex;

    /**
     * @param string $question
     * @param string[] $solutions
     * @param int $correctSolutionIndex
     */
    public function __construct($question, array $solutions, $correctSolutionIndex)
    {
        $this->question = $question;
        $this->solutions = $solutions;
        $this->correctIndex = $correctSolutionIndex;
    }

    /** @return string */
    public function getQuestion()
    {
        return $this->question;
    }

    /** @return string[]  */
    public function getSolutions()
    {
        return $this->solutions;
    }

    /** @return int */
    public function getCorrectSolutionIndex()
    {
        return $this->correctIndex;
    }

    /** @return bool */
    public function isCorrect($solutionToValidate)
    {
        return $this->solutions[$this->correctIndex] == $solutionToValidate;
    }
}