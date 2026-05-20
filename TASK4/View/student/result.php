<?php

include "../../Config/DatabaseConnection.php";
include "../../Model/QuizModel.php";

$attempt_id = 140;

$db = new DatabaseConnection();

$connection = $db->openConnection();

$model = new QuizModel();

$attempt =
$model->getAttempt(
    $connection,
    $attempt_id
);

$attemptRow =
$attempt->fetch_assoc();

$answers =
$model->getAnswers(
    $connection,
    $attempt_id
);

?>

<!DOCTYPE html>

<html>

<head>

<title>
Result
</title>

<style>

body{
    font-family: Arial;
    padding: 20px;
}

table{
    width: 100%;
    border-collapse: collapse;
}

th, td{
    padding: 10px;
    border: 1px solid black;
}

.pass{
    color: green;
}

.fail{
    color: red;
}

</style>

</head>

<body>

<h1>
Quiz Result
</h1>

<h2>
Total Score:
<?php echo $attemptRow["score"]; ?>
</h2>

<?php

if($attemptRow["score"] >= 60){
?>

<h2 class="pass">
PASS
</h2>

<?php
}
else{
?>

<h2 class="fail">
FAIL
</h2>

<?php
}
?>

<table>

<tr>

<th>Question</th>
<th>Your Answer</th>
<th>Correct Answer</th>

</tr>

<?php

while(
$a = $answers->fetch_assoc()
){

$question =
$model->getQuestion(
    $connection,
    $a["question_id"]
);

$questionRow =
$question->fetch_assoc();

$selected =
$model->getOptionById(
    $connection,
    $a["selected_option_id"]
);

$selectedRow =
$selected->fetch_assoc();

$correct =
$model->getCorrectOption(
    $connection,
    $a["question_id"]
);

$correctRow =
$correct->fetch_assoc();

?>

<tr>

<td>
<?php echo $questionRow["question_text"]; ?>
</td>

<td
style="color:
<?php

if($selectedRow["is_correct"] == 1){

    echo "green";
}
else{

    echo "red";
}
?>
"
>

<?php echo $selectedRow["option_text"]; ?>

</td>

<td>
<?php echo $correctRow["option_text"]; ?>
</td>

</tr>

<?php
}
?>

</table>

</body>

</html>