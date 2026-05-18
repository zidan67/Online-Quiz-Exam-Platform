<?php

class QuizModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // show published quizzes
    public function getPublishedQuizzes()
    {
        $sql = "SELECT * FROM quizzes WHERE status='published'";

        $result = $this->conn->query($sql);

        return $result;
    }

    // check previous attempt
    public function checkAttempt($quiz_id, $student_id)
    {
        $sql = "SELECT * FROM attempts
                WHERE quiz_id=? AND student_id=? 
                AND completed_at IS NOT NULL";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ii", $quiz_id, $student_id);

        $stmt->execute();

        return $stmt->get_result();
    }

    // create attempt
    public function createAttempt($quiz_id, $student_id)
    {
        $sql = "INSERT INTO attempts
                (quiz_id, student_id, score, started_at)
                VALUES (?, ?, NULL, NOW())";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ii", $quiz_id, $student_id);

        $stmt->execute();

        return $this->conn->insert_id;
    }

    // get questions
    public function getQuestions($quiz_id)
    {
        $sql = "SELECT * FROM questions WHERE quiz_id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $quiz_id);

        $stmt->execute();

        return $stmt->get_result();
    }

    // get options
    public function getOptions($question_id)
    {
        $sql = "SELECT * FROM options WHERE question_id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $question_id);

        $stmt->execute();

        return $stmt->get_result();
    }

    // check correct answer
    public function checkCorrect($option_id)
    {
        $sql = "SELECT options.is_correct,
                       questions.marks,
                       questions.id as question_id
                FROM options
                JOIN questions
                ON options.question_id = questions.id
                WHERE options.id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $option_id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // save answer
    public function saveAnswer($attempt_id, $question_id, $selected_option_id)
    {
        $sql = "INSERT INTO answers
                (attempt_id, question_id, selected_option_id)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iii",
            $attempt_id,
            $question_id,
            $selected_option_id
        );

        $stmt->execute();
    }

    // update score
    public function updateScore($attempt_id, $score)
    {
        $sql = "UPDATE attempts
                SET score=?,
                completed_at=NOW()
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ii", $score, $attempt_id);

        $stmt->execute();
    }
}
?>