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
        // The correct index must be set for the solutions, preferably 0
        if (!isset($this->solutions[$this->correctIndex]))
        {
            throw new InvalidArgumentException('Invalid index');
        }
    }

    // public function setId($id)
    // {
    //     $this->id = $id;
    // }

    // /** @return int */
    // public function getId()
    // {
    //     return $this->id;
    // }

    /** @return string */
    public function getQuestion()
    {
        return $this->question;
    }

    /** @return string[] */
    public function getSolutions()
    {
        return $this->solutions;
    }

    /** @return string */
    public function getCorrectSolution()
    {
        return $this->solutions[$this->correctIndex];
    }

    /** @return bool */
    public function isCorrect($solutionId)
    {
        return $this->correctIndex == $solutionId;
    }
}