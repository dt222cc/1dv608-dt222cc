<?php

class Result
{
    /**
     * @var int
     * @var int
     */
    private $correct;
    private $incorrect;

    /**
     * @param int
     * @param int
     */
    public function __construct($correct, $incorrect)
    {
        $this->correct = $correct;
        $this->incorrect = $incorrect;
    }

    /** @return int */
    public function getCorrect()
    {
        return $this->correct;
    }

    /** @return int */
    public function getIncorrect()
    {
        return $this->incorrect;
    }
}