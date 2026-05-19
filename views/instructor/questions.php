<?php
session_start();
require_once __DIR__ . "/../../Controller/AuthCheck.php";
require_once __DIR__ . "/../../Model/Quiz.php";
require_once __DIR__ . "/../../Model/Question.php";

requireInstructor();

$quizId = (int) ($_GET["quiz_id"] ?? 0);


$quiz = getQuizById(
    $quizId,
    $_SESSION["user_id"]
);

if (!$quiz) {
    die("Quiz not found.");
}

$questions = getQuestionsByQuiz($quizId);
$errors = $_SESSION["errors"] ?? [];
unset($_SESSION["errors"]);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Question Builder</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="page">
        <div class="topbar">
            <h1><?php echo htmlspecialchars($quiz["title"]); ?></h1>
            <a class="btn" href="quizzes.php">Back to Quizzes</a>
        </div>

        <p>Status: <span class="badge"><?php echo htmlspecialchars($quiz["status"]); ?></span> |
            Total Marks: <?php echo (int) $quiz["total_marks"]; ?></p>

        <?php foreach ($errors as $error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>

        <h2>Add Question</h2>
        <form action="../../Controller/QuestionController.php?action=store" method="POST" class="form-box">
            <input type="hidden" name="quiz_id" value="<?php echo $quizId; ?>">

            <label>Question Text</label>
            <textarea name="question_text"></textarea>

            <label>Marks</label>
            <input type="number" name="marks" min="1" value="1">

            <?php for ($i = 0; $i < 4; $i++): ?>
                <label>Option <?php echo chr(65 + $i); ?></label>
                <div class="option-line">
                    <input type="radio" name="correct_option" value="<?php echo $i; ?>" <?php echo $i === 0 ? "checked" : ""; ?>>
                    <input type="text" name="options[]" placeholder="Option <?php echo chr(65 + $i); ?>">
                </div>
            <?php endfor; ?>

            <button class="btn" type="submit">Add Question</button>
        </form>

        <h2>Questions</h2>
        <div id="message"></div>

        <?php foreach ($questions as $question): ?>
            <div class="question-card" id="question-<?php echo $question["id"]; ?>" data-id="<?php echo $question["id"]; ?>">
                <div class="question-display">
                    <h3 class="question-text"><?php echo htmlspecialchars($question["question_text"]); ?></h3>
                    <p>Marks: <span class="question-marks"><?php echo (int) $question["marks"]; ?></span></p>
                    <ol type="A">
                        <?php foreach ($question["options"] as $option): ?>
                            <li class="option-text" data-correct="<?php echo (int) $option["is_correct"]; ?>">
                                <?php echo htmlspecialchars($option["option_text"]); ?>
                                <?php if ($option["is_correct"]): ?>
                                    <strong>(Correct)</strong>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                    <button class="btn small edit-question">Edit</button>
                    <button class="btn danger small delete-question">Delete</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="../../assets/js/questions.js"></script>
</body>
</html>