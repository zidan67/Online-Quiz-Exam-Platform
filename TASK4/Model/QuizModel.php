<?php

class QuizModel{


    // GET QUESTION

    function getQuestion(
        $connection,
        $question_id
    ){

        $sql = "SELECT *
                FROM questions
                WHERE id='$question_id'";

        return $connection->query($sql);
    }



    // GET ATTEMPT

    function getAttempt(
        $connection,
        $attempt_id
    ){

        $sql = "SELECT *
                FROM attempts
                WHERE id='$attempt_id'";

        return $connection->query($sql);
    }



    // GET ANSWERS

    function getAnswers(
        $connection,
        $attempt_id
    ){

        $sql = "SELECT *
                FROM answers
                WHERE attempt_id='$attempt_id'";

        return $connection->query($sql);
    }



    // GET OPTION BY ID

    function getOptionById(
        $connection,
        $id
    ){

        $sql = "SELECT *
                FROM options
                WHERE id='$id'";

        return $connection->query($sql);
    }



    // GET CORRECT OPTION

    function getCorrectOption(
        $connection,
        $question_id
    ){

        $sql = "SELECT *
                FROM options
                WHERE question_id='$question_id'
                AND is_correct=1";

        return $connection->query($sql);
    }



    // GET STUDENT RESULTS

    function getStudentResults(
        $connection,
        $student_id
    ){

        $sql = "SELECT attempts.*,
                quizzes.title

                FROM attempts

                JOIN quizzes
                ON attempts.quiz_id = quizzes.id

                WHERE attempts.student_id='$student_id'

                ORDER BY attempts.completed_at DESC";

        return $connection->query($sql);
    }



    // GET INSTRUCTOR QUIZZES

    function getInstructorQuizzes(
        $connection,
        $instructor_id
    ){

        $sql = "SELECT *
                FROM quizzes
                WHERE instructor_id='$instructor_id'";

        return $connection->query($sql);
    }



    // GET QUIZ ATTEMPTS

    function getQuizAttempts(
        $connection,
        $quiz_id
    ){

        $sql = "SELECT attempts.*,
                users.name

                FROM attempts

                JOIN users
                ON attempts.student_id = users.id

                WHERE attempts.quiz_id='$quiz_id'
                AND attempts.completed_at IS NOT NULL";

        return $connection->query($sql);
    }



    // LEADERBOARD

    function getLeaderboard(
        $connection
    ){

        $sql = "SELECT users.name,
                SUM(attempts.score) AS total_score

                FROM attempts

                JOIN users
                ON attempts.student_id = users.id

                GROUP BY attempts.student_id

                ORDER BY total_score DESC

                LIMIT 10";

        return $connection->query($sql);
    }

}

?>