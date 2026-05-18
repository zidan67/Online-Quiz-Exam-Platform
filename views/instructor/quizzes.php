<?php
session_start();
require_once __DIR__ . "/../../controllers/AuthCheck.php";
require_once __DIR__ . "/../../models/Quiz.php";

requireInstructor();
$quizzes = getQuizzesByInstructor($_SESSION["user_id"]);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Quizzes</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="page">
        <div class="topbar">
            <h1>My Quizzes</h1>
            <a class="btn" href="quiz_form.php">Create Quiz</a>
        </div>

        <div id="message"></div>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Total Marks</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quizzes as $quiz): ?>
                    <tr id="quiz-<?php echo $quiz["id"]; ?>">
                        <td><?php echo htmlspecialchars($quiz["title"]); ?></td>
                        <td><?php echo (int) $quiz["total_marks"]; ?></td>
                        <td><?php echo (int) $quiz["time_limit_minutes"]; ?> min</td>
                        <td>
                            <span class="badge status-badge"><?php echo htmlspecialchars($quiz["status"]); ?></span>
                        </td>
                        <td class="actions">
                            <a class="btn small" href="questions.php?quiz_id=<?php echo $quiz["id"]; ?>">Questions</a>
                            <a class="btn small" href="quiz_form.php?id=<?php echo $quiz["id"]; ?>">Edit</a>
                            <button class="btn small toggle-quiz" data-id="<?php echo $quiz["id"]; ?>">
                                <?php echo $quiz["status"] === "published" ? "Unpublish" : "Publish"; ?>
                            </button>
                            <form action="../../controllers/QuizController.php?action=delete" method="POST" class="inline-form">
                                <input type="hidden" name="quiz_id" value="<?php echo $quiz["id"]; ?>">
                                <button class="btn danger small" type="submit" onclick="return confirm('Delete this quiz?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="../../assets/js/quiz.js"></script>
</body>
</html>
