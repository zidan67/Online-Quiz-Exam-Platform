<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . "/../models/Quiz.php";
require_once __DIR__ . "/../models/Question.php";

if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "instructor") {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Login as instructor first."]);
    exit;
}

$instructorId = $_SESSION["user_id"];
$method = $_SERVER["REQUEST_METHOD"];
$path = $_GET["path"] ?? "";

if ($path === "" && isset($_SERVER["PATH_INFO"])) {
    $path = trim($_SERVER["PATH_INFO"], "/");
}

$parts = explode("/", trim($path, "/"));
$input = json_decode(file_get_contents("php://input"), true);
if (!is_array($input)) {
    $input = [];
}

if ($method === "POST" && count($parts) === 3 && $parts[0] === "quizzes" && $parts[2] === "toggle") {
    $quizId = (int) $parts[1];
    $result = toggleQuizStatus($quizId, $instructorId);

    if ($result === "no_questions") {
        http_response_code(422);
        echo json_encode(["success" => false, "message" => "Add at least one question before publishing."]);
        exit;
    }

    if (!$result) {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Quiz not found."]);
        exit;
    }

    echo json_encode(["success" => true, "status" => $result]);
    exit;
}

if (($method === "PATCH" || ($method === "POST" && ($_POST["_method"] ?? "") === "PATCH")) && count($parts) === 2 && $parts[0] === "questions") {
    $questionId = (int) $parts[1];
    $question = getQuestionWithQuizOwner($questionId);

    if (!$question || (int) $question["instructor_id"] !== (int) $instructorId) {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Question not found."]);
        exit;
    }

    $questionText = trim($input["question_text"] ?? "");
    $marks = (int) ($input["marks"] ?? 1);
    $options = $input["options"] ?? [];
    $correctOption = $input["correct_option"] ?? "";

    if ($questionText === "" || $marks < 1 || count($options) !== 4 || $correctOption === "") {
        http_response_code(422);
        echo json_encode(["success" => false, "message" => "Question, marks, four options, and correct answer are required."]);
        exit;
    }

    foreach ($options as $option) {
        if (trim($option) === "") {
            http_response_code(422);
            echo json_encode(["success" => false, "message" => "All option fields are required."]);
            exit;
        }
    }

    updateQuestionAndOptions($questionId, $questionText, $marks, array_map("trim", $options), (int) $correctOption);
    echo json_encode(["success" => true, "message" => "Question updated."]);
    exit;
}

if ($method === "DELETE" && count($parts) === 2 && $parts[0] === "questions") {
    $questionId = (int) $parts[1];
    $question = getQuestionWithQuizOwner($questionId);

    if (!$question || (int) $question["instructor_id"] !== (int) $instructorId) {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Question not found."]);
        exit;
    }

    deleteQuestion($questionId);
    echo json_encode(["success" => true, "message" => "Question deleted."]);
    exit;
}

http_response_code(404);
echo json_encode(["success" => false, "message" => "API route not found."]);
?>