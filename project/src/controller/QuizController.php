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
     * Get the total amount of questions to be handled from the user choice within setup.
     *
     * Check if the solution is correct, depending on the result we increase the correct-/incorrect counter by one.
     * When game is over the results gets presented to the user.
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