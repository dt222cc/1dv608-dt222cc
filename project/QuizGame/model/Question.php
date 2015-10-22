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
        if (count($solutions) != 3) {
            throw new InvalidArgumentException('Invalid array size, should be 3');
        }
        if (!isset($solutions[$correctSolutionIndex])) {
            throw new InvalidArgumentException('Invalid index');
        }

        $question = strip_tags($question);
        $question = preg_replace("/[^A-Za-z0-9#._;:,'-]/", '', $question);

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

    /** @return bool */
    public function isCorrect($solutionToValidate)
    {
        return $this->solutions[$this->correctIndex] == $solutionToValidate;
    }
}