<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/Quiz.php";

function getQuestionsByQuiz($quizId)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM questions WHERE quiz_id = ? ORDER BY order_index ASC, id ASC");
    $stmt->execute([$quizId]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($questions as $key => $question) {
        $stmt = $pdo->prepare("SELECT * FROM options WHERE question_id = ? ORDER BY id ASC");
        $stmt->execute([$question["id"]]);
        $questions[$key]["options"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $questions;
}

function getQuestionWithQuizOwner($questionId)
{
    global $pdo;
    $sql = "SELECT questions.*, quizzes.instructor_id
            FROM questions
            JOIN quizzes ON questions.quiz_id = quizzes.id
            WHERE questions.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$questionId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addQuestion($quizId, $questionText, $marks, $options, $correctOption)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COALESCE(MAX(order_index), 0) + 1 FROM questions WHERE quiz_id = ?");
    $stmt->execute([$quizId]);
    $orderIndex = (int) $stmt->fetchColumn();

    $stmt = $pdo->prepare("INSERT INTO questions (quiz_id, question_text, marks, order_index) VALUES (?, ?, ?, ?)");
    $stmt->execute([$quizId, $questionText, $marks, $orderIndex]);
    $questionId = $pdo->lastInsertId();

    foreach ($options as $index => $optionText) {
        $isCorrect = ((int) $correctOption === $index) ? 1 : 0;
        $stmt = $pdo->prepare("INSERT INTO options (question_id, option_text, is_correct) VALUES (?, ?, ?)");
        $stmt->execute([$questionId, $optionText, $isCorrect]);
    }

    updateQuizTotalMarks($quizId);
    return $questionId;
}

function updateQuestionAndOptions($questionId, $questionText, $marks, $options, $correctOption)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE questions SET question_text = ?, marks = ? WHERE id = ?");
    $stmt->execute([$questionText, $marks, $questionId]);

    $stmt = $pdo->prepare("SELECT id FROM options WHERE question_id = ? ORDER BY id ASC");
    $stmt->execute([$questionId]);
    $oldOptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($oldOptions as $index => $oldOption) {
        $isCorrect = ((int) $correctOption === $index) ? 1 : 0;
        $optionText = $options[$index] ?? "";
        $stmt = $pdo->prepare("UPDATE options SET option_text = ?, is_correct = ? WHERE id = ?");
        $stmt->execute([$optionText, $isCorrect, $oldOption["id"]]);
    }

    $question = getQuestionWithQuizOwner($questionId);
    updateQuizTotalMarks($question["quiz_id"]);
}

function deleteQuestion($questionId)
{
    global $pdo;
    $question = getQuestionWithQuizOwner($questionId);

    if (!$question) {
        return false;
    }

    $stmt = $pdo->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->execute([$questionId]);
    updateQuizTotalMarks($question["quiz_id"]);

    return true;
}
?>