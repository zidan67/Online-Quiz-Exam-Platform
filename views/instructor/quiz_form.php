<?php
session_start();
require_once __DIR__ . "/../../controllers/AuthCheck.php";
require_once __DIR__ . "/../../models/Quiz.php";

requireInstructor();

$quiz = null;
$isEdit = isset($_GET["id"]);
if ($isEdit) {
    $quiz = getQuizById((int) $_GET["id"], $_SESSION["user_id"]);
    if (!$quiz) {
        die("Quiz not found.");
    }
}

$errors = $_SESSION["errors"] ?? [];
unset($_SESSION["errors"]);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $isEdit ? "Edit Quiz" : "Create Quiz"; ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="page narrow">
        <h1><?php echo $isEdit ? "Edit Quiz" : "Create Quiz"; ?></h1>

        <?php foreach ($errors as $error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endforeach; ?>

        <form action="../../controllers/QuizController.php?action=<?php echo $isEdit ? "update" : "store"; ?>" method="POST" class="form-box">
            <?php if ($isEdit): ?>
                <input type="hidden" name="quiz_id" value="<?php echo $quiz["id"]; ?>">
            <?php endif; ?>

            <label>Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($quiz["title"] ?? ""); ?>">

            <label>Description</label>
            <textarea name="description"><?php echo htmlspecialchars($quiz["description"] ?? ""); ?></textarea>

            <?php if ($isEdit): ?>
                <label>Total Marks</label>
                <input type="number" value="<?php echo (int) $quiz["total_marks"]; ?>" readonly>
            <?php endif; ?>

            <label>Time Limit Minutes</label>
            <input type="number" name="time_limit_minutes" min="1" value="<?php echo htmlspecialchars($quiz["time_limit_minutes"] ?? "10"); ?>">

            <label>Status</label>
            <select name="status">
                <?php $status = $quiz["status"] ?? "draft"; ?>
                <option value="draft" <?php echo $status === "draft" ? "selected" : ""; ?>>Draft</option>
                <option value="published" <?php echo $status === "published" ? "selected" : ""; ?>>Published</option>
            </select>

            <button class="btn" type="submit">Save</button>
            <a class="link" href="quizzes.php">Back</a>
        </form>
    </div>
</body>
</html>
