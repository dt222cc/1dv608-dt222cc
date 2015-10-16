<?php

class Result
{
    private $correct;
    private $incorrect;

    /** @param session variables / int */
    public function __construct($correct, $incorrect)
    {
        $this->correct = $correct;
        $this->incorrect = $incorrect;
    }

    public function getCorrect()
    {
        return $this->correct;
    }

    public function getIncorrect()
    {
        return $this->incorrect;
    }

    public function getTotal()
    {
        return $this->correct + $this->incorrect;
    }
}