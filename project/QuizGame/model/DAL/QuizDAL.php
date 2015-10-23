<?php

require_once("exceptions/QuestionAlreadyExistsException.php");

class QuizDAL
{
    /**
     * Load the quiz, get all questions from storage like a database
     *
     * @param int
     * @return Question[]
     */
    public function getQuestions($limit)
    {
        $questions = array();

        $conn = $this->establishConnection();

        /* RAND() works for this project, when there's not so much rows in the database.*/
        if ($stmt = $conn->prepare("SELECT * FROM quiz_game ORDER BY RAND() LIMIT " . $limit)) {
            $stmt->execute();
            $stmt->bind_result($id, $question, $solution1, $solution2, $solution3, $correctSolutionIndex);
            while ($stmt->fetch()) {
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
     * @param Question
     * @throws QuestionAlreadyExistsException
     * @return bool
     */
    public function saveQuestion(Question $q)
    {
        $conn = $this->establishConnection();

        // Check if question already exists
        if ($stmt = $conn->prepare("SELECT question FROM quiz_game WHERE question = ? LIMIT 1")) {
            $question = $conn->real_escape_string($q->getQuestion());
            $stmt->bind_param("s", $question);
            $stmt->execute();
            $stmt->bind_result($result);
            if($stmt->fetch()) {
                $conn->close();
                throw new QuestionAlreadyExistsException();
            }
        }

        // Then try to add to database
        if ($stmt = $conn->prepare("INSERT INTO quiz_game (question, solution_1, solution_2, solution_3, correct_solution_index) VALUES (?, ?, ?, ?, ?)")) {
            $question = $q->getQuestion();
            $s1 = $q->getSolutions()[0];
            $s2 = $q->getSolutions()[1];
            $s3 = $q->getSolutions()[2];
            $correctIndex = $q->getCorrectSolutionIndex();
            $stmt->bind_param('ssssi', $question, $s1, $s2, $s3, $correctIndex);
            $stmt->execute();
            $conn->close();
            return true;
        }
        $conn->close();

        return false;
    }

    /**
     * Establish a connection to the database
     *
     * @return mysqli
     */
    private function establishConnection()
    {
         // Create connection
        $conn = new mysqli(Database::HOST, Database::USER, Database::PASSWORD, Database::SCHEMA);

        /* Check connection */
        if ($conn->connect_error) {
            printf("Connect failed: %s\n", $conn->connect_error);
            exit();
        }
        return $conn;
    }
}