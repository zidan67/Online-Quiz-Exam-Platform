<?php
session_start();
require_once __DIR__ . "/AuthCheck.php";
require_once __DIR__ . "/../models/Quiz.php";

requireInstructor();

$action = $_GET["action"] ?? "list";
$instructorId = $_SESSION["user_id"];

if ($action === "store" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $timeLimit = (int) ($_POST["time_limit_minutes"] ?? 0);
    $status = $_POST["status"] ?? "draft";
    $errors = [];

    if ($title === "") {
        $errors[] = "Title is required.";
    }
    if ($timeLimit < 1) {
        $errors[] = "Time limit must be a positive number.";
    }
    if (!in_array($status, ["draft", "published"])) {
        $status = "draft";
    }
    if ($status === "published") {
        $errors[] = "Add at least one question before publishing.";
    }

    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        header("Location: ../views/instructor/quiz_form.php");
        exit;
    }

    $quizId = createQuiz($instructorId, $title, $description, $timeLimit, $status);
    header("Location: ../views/instructor/questions.php?quiz_id=" . $quizId);
    exit;
}

if ($action === "update" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $quizId = (int) ($_POST["quiz_id"] ?? 0);
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $timeLimit = (int) ($_POST["time_limit_minutes"] ?? 0);
    $status = $_POST["status"] ?? "draft";
    $errors = [];

    $quiz = getQuizById($quizId, $instructorId);
    if (!$quiz) {
        $errors[] = "Quiz not found.";
    }
    if ($title === "") {
        $errors[] = "Title is required.";
    }
    if ($timeLimit < 1) {
        $errors[] = "Time limit must be a positive number.";
    }
    if ($status === "published" && countQuizQuestions($quizId) < 1) {
        $errors[] = "Add at least one question before publishing.";
    }

    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        header("Location: ../views/instructor/quiz_form.php?id=" . $quizId);
        exit;
    }

    updateQuiz($quizId, $instructorId, $title, $description, $timeLimit, $status);
    header("Location: ../views/instructor/quizzes.php");
    exit;
}

if ($action === "delete" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $quizId = (int) ($_POST["quiz_id"] ?? 0);
    deleteQuiz($quizId, $instructorId);
    header("Location: ../views/instructor/quizzes.php");
    exit;
}

header("Location: ../views/instructor/quizzes.php");
exit;
?>
