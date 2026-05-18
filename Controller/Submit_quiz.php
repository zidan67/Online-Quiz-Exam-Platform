<?php

session_start();

header("Content-Type: application/json");

require_once "../Model/DatabaseConnection.php";
require_once "../Model/QuizModel.php";

$db = new DatabaseConnection();

$conn = $db->openConnection();

$model = new QuizModel($conn);

$attempt_id = $_POST['attempt_id'];

$answers = $_POST['answers'];

$total_score = 0;

foreach($answers as $question_id => $option_id)
{
    $check = $model->checkCorrect($option_id);

    if($check['is_correct'] == 1)
    {
        $total_score =
        $total_score + $check['marks'];
    }

    $model->saveAnswer(
        $attempt_id,
        $question_id,
        $option_id
    );
}

$model->updateScore(
    $attempt_id,
    $total_score
);

echo json_encode([
    "status" => "success",
    "message" => "Quiz Submitted"
]);

?>