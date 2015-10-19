<?php

class QuizDAL
{
    /**
     * Load the quiz, get all questions from storage like a database
     *
     * @return Question[] $questions
     */
    public function loadQuiz()
    {
        $questions = array();

        $conn = $this->establishConnection();
        $query = "SELECT question, solution_1, solution_2, solution_3, correct_solution_index FROM quiz_game";

        if ($stmt = $conn->prepare($query))
        {
            $stmt->execute();
            $stmt->bind_result($question, $solution1, $solution2, $solution3, $correctSolutionIndex);

            while ($stmt->fetch())
            {
                $currentQuestion = new Question($question, array($solution1, $solution2, $solution3), $correctSolutionIndex);
                $questions[] = $currentQuestion;
            }
        }
        $conn->close();

        return $questions;
    }

    /**
     * Save the quiz when the question list has been altered
     *
     * @param Question[] $questions
     */
    public function saveQuiz(array $questions)
    {
        // Placeholder, might add option to add questions from the page with somekind of form (admin only)
    }

    /**
     * Establish a connection to the database
     * @return mysqli connection
     */
    private function establishConnection()
    {
         // Create connection
        $conn = new mysqli(Database::HOST, Database::USER, Database::PASSWORD, Database::SCHEMA);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
}