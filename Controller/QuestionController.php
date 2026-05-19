<?php
session_start();
require_once __DIR__ . "/AuthCheck.php";
require_once __DIR__ . "/../Model/Quiz.php";
require_once __DIR__ . "/../Model/Question.php";

requireInstructor();

$action = $_GET["action"] ?? "";
$instructorId = $_SESSION["user_id"];

if ($action === "store" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $quizId = (int) ($_POST["quiz_id"] ?? 0);
    $questionText = trim($_POST["question_text"] ?? "");
    $marks = (int) ($_POST["marks"] ?? 1);
    $options = $_POST["options"] ?? [];
    $correctOption = $_POST["correct_option"] ?? "";
    $errors = [];

    $quiz = getQuizById($quizId, $instructorId);
    if (!$quiz) {
        $errors[] = "Quiz not found.";
    }
    if ($questionText === "") {
        $errors[] = "Question text is required.";
    }
    if ($marks < 1) {
        $errors[] = "Marks must be positive.";
    }
    if (count($options) !== 4) {
        $errors[] = "Four options are required.";
    }
    foreach ($options as $option) {
        if (trim($option) === "") {
            $errors[] = "All option fields are required.";
            break;
        }
    }
    if ($correctOption === "" || !isset($options[(int) $correctOption])) {
        $errors[] = "Select the correct answer.";
    }

    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        header("Location: ../View/instructor/questions.php?quiz_id=" . $quizId);
        exit;
    }

    addQuestion($quizId, $questionText, $marks, array_map("trim", $options), (int) $correctOption);
    header("Location: ../View/instructor/questions.php?quiz_id=" . $quizId);
    exit;
}

header("Location: ../View/instructor/quizzes.php");
exit;
?>