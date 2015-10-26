<?php

class QuizController
{
    /** @var Quiz */
    private $model;

    /** @var QuizView */
    private $view;

    /**
     * @param Quiz
     * @param QuizView
     */
    public function __construct(Quiz $model, QuizView $view)
    {
	    $this->model = $model;
	    $this->view = $view;
    }

    /**
     * Depending on which submit button was press:
     *
     * Get the amount of questions for the quiz and initiate start game
     * Solve question and set when the game is over
     * Add a new question to the list if it passed the validation
     */
    public function doQuiz()
    {
        if ($this->view->didUserWantToPlay()) {
            $amountOfQuestions = $this->view->getAmountOfQuestions();
            $this->model->startQuiz($amountOfQuestions);
        }
        else if ($this->view->didUserSolveAQuestion()) {
            $solutionToValidate = $this->view->getSolution();
            $isCorrect = $this->model->checkSolution($solutionToValidate);
            $this->model->updateResults($isCorrect);

            if ($this->model->isOver()) {
                $this->view->setIsOver();
            }
        }
        else if ($this->view->didUserWantToAddNewQuestion()) {
            if ($this->view->validateNewQuestion() == "") {
                $theNewQuestion = $this->view->getTheNewQuestionToAdd();

                try {
                    if($this->model->addNewQuestionToDatabase($theNewQuestion)) {
                        $this->view->setAddNewQuestionSuccessful();
                    }
                }
                catch (QuestionAlreadyExistsException $e) {
                    $this->view->setQuestionAlreadyExists();
                }
            }
        }
    }
}