<?php

class QuizView
{
    const QUIZ_SETUP = "QuizView::Setup";
    const QUIZ_QUESTIONS = "QuizView::Questions";
    const QUIZ_SOLVE = "QuizView::Solve";
    const QUIZ_SOLUTION = "QuizView::RadioSolution";
    const QUIZ_NEWQUESTION = "QuizView::NewQuestion";
    const QUIZ_FIRSTSOLUTION = "QuizView::FirstSolution";
    const QUIZ_SECONDSOLUTION = "QuizView::SecondSolution";
    const QUIZ_THIRDSOLUTION = "QuizView::ThirdSolution";
    const QUIZ_ADDNEWQUESTION = "QuizView::AddNewQuestion";

    const QUIZ_URL = "index.php";
    const QUIZ_REGISTERURL = "newQuestion";

    const QUIZ_THEME = "Who is the author of the following quote?";

    private $isOver = false;

    /** @var Quiz */
    private $model;

    /** @param Quiz */
    public function __construct(Quiz $quiz)
    {
        $this->model = $quiz;
    }

    /**
     * Set game is over
     */
    public function setIsOver()
    {
        $this->isOver = true;
    }

    /**
     * Accessor methods for form submits
     *
     * @return boolean true if user did press submit
     */
    public function didUserWantToPlay()
    {
        return isset($_POST[self::QUIZ_SETUP]);
    }

    public function didUserSolveAQuestion()
    {
        return isset($_POST[self::QUIZ_SOLVE]);
    }

    public function didUserWantToAddNewQuestion()
    {
        return isset($_POST[self::QUIZ_ADDNEWQUESTION]);
    }

    /**
     * Accessor method for getting the amount of questions to fetch from database
     *
     * @return int
     */
    public function getAmountOfQuestions()
    {
        return intval($_POST[self::QUIZ_QUESTIONS]);
    }

    /**
     * Accessor method for getting the user picked solution
     *
     * @return string
     */
    public function getSolution()
    {
        return $_POST[self::QUIZ_SOLUTION];
    }

    /**
     * Build a new question from the filled in form
     *
     * @return Question
     */
    public function getTheNewQuestionToAdd()
    {
        return new Question($this->getNewQuestion(), array($this->getFirstSolution(), $this->getSecondSolution(), $this->getThirdSolution()), 0);
    }

    /**
     * Generate the correct view (setup/solveSolution/results/addNewQuestion)
     *
     * @return string HTML
     */
    public function getResponse()
    {
        // Registration of a new question
        if ($this->urlIsForNewQuestion()) {
            $message = "";
            if ($this->didUserWantToAddNewQuestion()) {
                $message = $this->validateNewQuestion($message);
            }
            return $this->generateAddQuestionHTML($message);
        }
        // Part of the quiz game
        else if ($this->isOver) {
            return $this->generateQuizResultsHTML();
        }
        else if (isset($_POST[self::QUIZ_SETUP]) == true || isset($_POST[self::QUIZ_SOLVE]) == true) {
            return $this->generateSolveQuestionFormHTML();
        }
        // The quiz setup (start/default page)
        return $this->generateQuizSetupHTML();
    }

    /**
     * Validate the new question and generate error message to return
     *
     * @return string
     */
    public function validateNewQuestion($message = "")
    {
        if ($this->getNewQuestion() == "")       { $message .= "The question is missing<br>"; }
        if ($this->getFirstSolution() == "")     { $message .= "Correct solution is missing<br>"; }
        if ($this->getSecondSolution() == "")    { $message .= "Second solution is missing<br>"; }
        if ($this->getThirdSolution() == "")     { $message .= "Third solution is missing<br>"; }
        if ($this->containsSpecialCharacters())  { $message .= "Fields contains invalid characters<br>"; }
        if ($this->containsDuplicateSolutions()) { $message .= "Fields contains duplicate solutions<br>"; }
        else if ($message == "") {
            echo "Success! Now check if the insert to database is ok";
        }

        return $message;
    }

    /**
     * Some introduction and setup form for picking amount of questions to be solved.
     *
     * @return string HTML
     */
    private function generateQuizSetupHTML()
    {
        return "
            <div>
                <a href='".self::QUIZ_URL."?".self::QUIZ_REGISTERURL."'>Register a new question for the quiz.</a>
            </div>
            <div>
                <p>This quiz is about matching the following question with the correct solution, duh.. it's a quiz.</p>
                <p>There will be 3 possible solutions but only one of them is correct.</p>
                <p>Your task will be picking the correct solution with no outside help.</p>
            </div>

            <form method='post'>
                <b>Pick the amount of questions.</b>
                <input type='radio' name='".self::QUIZ_QUESTIONS."' value='5' checked> 5
                <input type='radio' name='".self::QUIZ_QUESTIONS."' value='10'> 10
                <input type='radio' name='".self::QUIZ_QUESTIONS."' value='15'> 15
                <input type='radio' name='".self::QUIZ_QUESTIONS."' value='20'> 20
                <br><br>
                <input type='submit' name='".self::QUIZ_SETUP."' value='Submit' />
            </form>
	    ";
    }

    /**
     * Generate form for solving the current question. Answers have a randomized order.
     *
     * @return string HTML
     */
    private function generateSolveQuestionFormHTML()
    {
        $question = $this->model->getQuestion();
        $solutions = $question->getSolutions();
        shuffle($solutions);

        return "<form method='post'>
                <b>".self::QUIZ_THEME."</b>
                <p>".$question->getQuestion()."</p>
                <input type='radio' name='".self::QUIZ_SOLUTION."' value='".$solutions[0]."' checked>" .$solutions[0]."<br>
                <input type='radio' name='".self::QUIZ_SOLUTION."' value='".$solutions[1]."'>" .$solutions[1]."<br>
                <input type='radio' name='".self::QUIZ_SOLUTION."' value='".$solutions[2]."'>" .$solutions[2]."<br><br>
                <input type='submit' name='".self::QUIZ_SOLVE."' value='Submit' />
            </form>
        ";
    }

    /**
     * Generate the results
     *
     * @return string HTML
     */
    private function generateQuizResultsHTML()
    {
        $result = $this->model->getResult();
        $correct = $result->getCorrect();
        $incorrect = $result->getIncorrect();

        return "
            <div>
                <b>Your results: </b>
                <p>- Correct: ".$correct."</p>
                <p>- Incorrect: ".$incorrect."</p>
                <a href='".self::QUIZ_URL."'>Play again</a>
            </div>
        ";
    }

    /**
     * Generate the question registration form
     *
     * @return string HTML
     */
    private function generateAddQuestionHTML($message)
    {
        return "<p><a href ='".self::QUIZ_URL."'>Go back</a></p>
            <p style ='color:#ff0000'><b>There's no user restriction for adding a new question to the database, at this moment.</b></p>
            <p><b>Form for adding a question to the database.</b></p>
            <p style ='color:#ff0000'>".$message."</p>
            <form method='post'>
                <label for='".self::QUIZ_NEWQUESTION."'>The question</label><br>
                <textarea name='".self::QUIZ_NEWQUESTION."' rows='4' cols='50' value='".$this->getNewQuestion()."'></textarea>
                <br><br>
                <label for='".self::QUIZ_FIRSTSOLUTION."'>Correct solution</label><br>
                <input type='text' name='".self::QUIZ_FIRSTSOLUTION."' value='".$this->getFirstSolution()."' />
                <br><br>
                <label for='".self::QUIZ_SECONDSOLUTION."'>Second solution</label><br>
                <input type='text' name='".self::QUIZ_SECONDSOLUTION."' value='".$this->getSecondSolution()."' />
                <br><br>
                <label for='".self::QUIZ_THIRDSOLUTION."'>Third solution</label><br>
                <input type='text' name='".self::QUIZ_THIRDSOLUTION."' value='".$this->getThirdSolution()."' />
                <br><br>
                <input type='submit' name='".self::QUIZ_ADDNEWQUESTION."' value='Submit' />
            </form>
        ";
    }

    /**
     * Helper method for redirecting to the register new question form
     *
     * @return bool
     */
    private function urlIsForNewQuestion()
    {
        return isset($_GET[self::QUIZ_REGISTERURL]) == true;
    }

    /**
     * Remove characters that are not allowed
     *
     * @param mixed $string
     * @return mixed
     */
    private function removeSomeSpecialCharacters($string)
    {
        $string = strip_tags($string);
        return preg_replace("/[^A-Za-z0-9#. _;:,'-]/", '', $string);
    }

    /**
     * Checks if the strings contains not allowed special characters
     *
     * @return bool
     */
    private function containsSpecialCharacters()
    {
        if ($this->removeSomeSpecialCharacters($this->getNewQuestion()) != $this->getNewQuestion() ||
            $this->removeSomeSpecialCharacters($this->getFirstSolution()) != $this->getFirstSolution() ||
            $this->removeSomeSpecialCharacters($this->getSecondSolution()) != $this->getSecondSolution() ||
            $this->removeSomeSpecialCharacters($this->getThirdSolution()) != $this->getThirdSolution())
        {
            return true;
        }
        return false;
    }

    /**
     * Checks for duplicate solutions
     *
     * @return bool
     */
    private function containsDuplicateSolutions()
    {
        if ($this->getFirstSolution() != "" && $this->getSecondSolution() != "" && $this->getThirdSolution() != "") {
            if ($this->getFirstSolution() == $this->getSecondSolution() ||
                $this->getFirstSolution() == $this->getThirdSolution() ||
                $this->getSecondSolution() == $this->getThirdSolution())
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Getters for the new question form
     *
     * @return mixed
     */
    private function getNewQuestion() {
        if (isset($_POST[self::QUIZ_NEWQUESTION]))
            return $_POST[self::QUIZ_NEWQUESTION];
        return "";
    }

    private function getFirstSolution() {
        if (isset($_POST[self::QUIZ_FIRSTSOLUTION]))
            return $_POST[self::QUIZ_FIRSTSOLUTION];
        return "";
    }

    private function getSecondSolution() {
        if (isset($_POST[self::QUIZ_SECONDSOLUTION]))
            return $_POST[self::QUIZ_SECONDSOLUTION];
        return "";
    }

    private function getThirdSolution() {
        if (isset($_POST[self::QUIZ_THIRDSOLUTION]))
            return $_POST[self::QUIZ_THIRDSOLUTION];
        return "";
    }
}