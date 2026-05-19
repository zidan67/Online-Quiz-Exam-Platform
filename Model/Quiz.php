<?php
require_once __DIR__ . "/../config/database.php";

function getQuizzesByInstructor($instructorId)
{
    global $pdo;
    $sql = "SELECT * FROM quizzes WHERE instructor_id = ? ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$instructorId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getQuizById($quizId, $instructorId)
{
    global $pdo;
    $sql = "SELECT * FROM quizzes WHERE id = ? AND instructor_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$quizId, $instructorId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createQuiz($instructorId, $title, $description, $timeLimit, $status)
{
    global $pdo;
    $sql = "INSERT INTO quizzes (instructor_id, title, description, total_marks, time_limit_minutes, status)
            VALUES (?, ?, ?, 0, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$instructorId, $title, $description, $timeLimit, $status]);
    return $pdo->lastInsertId();
}

function updateQuiz($quizId, $instructorId, $title, $description, $timeLimit, $status)
{
    global $pdo;
    $sql = "UPDATE quizzes
            SET title = ?, description = ?, time_limit_minutes = ?, status = ?
            WHERE id = ? AND instructor_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$title, $description, $timeLimit, $status, $quizId, $instructorId]);
}

function deleteQuiz($quizId, $instructorId)
{
    global $pdo;
    $sql = "DELETE FROM quizzes WHERE id = ? AND instructor_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$quizId, $instructorId]);
}

function countQuizQuestions($quizId)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM questions WHERE quiz_id = ?");
    $stmt->execute([$quizId]);
    return (int) $stmt->fetchColumn();
}

function updateQuizTotalMarks($quizId)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COALESCE(SUM(marks), 0) FROM questions WHERE quiz_id = ?");
    $stmt->execute([$quizId]);
    $total = (int) $stmt->fetchColumn();

    $stmt = $pdo->prepare("UPDATE quizzes SET total_marks = ? WHERE id = ?");
    $stmt->execute([$total, $quizId]);
    return $total;
}

function toggleQuizStatus($quizId, $instructorId)
{
    global $pdo;
    $quiz = getQuizById($quizId, $instructorId);

    if (!$quiz) {
        return false;
    }

    if ($quiz["status"] === "draft" && countQuizQuestions($quizId) < 1) {
        return "no_questions";
    }

    $newStatus = $quiz["status"] === "published" ? "draft" : "published";
    $stmt = $pdo->prepare("UPDATE quizzes SET status = ? WHERE id = ? AND instructor_id = ?");
    $stmt->execute([$newStatus, $quizId, $instructorId]);

    return $newStatus;
}
?>