<?php
session_start();

$_SESSION["user_id"] = 115;

$_SESSION["role"] = "instructor";

include "../../Config/DatabaseConnection.php";

include "../../Model/QuizModel.php";

$instructor_id = $_SESSION["user_id"];

$db = new DatabaseConnection();

$connection = $db->openConnection();

$model = new QuizModel();

$quizzes =
$model->getInstructorQuizzes(
    $connection,
    $instructor_id
);

$quiz_id = $_GET["quiz_id"] ?? "";

?>

<!DOCTYPE html>

<html>

<head>

<title>
Analytics
</title>

</head>

<body>

<h1>
Instructor Analytics
</h1>

<form method="GET">

<select name="quiz_id">

<?php

while(
$q = $quizzes->fetch_assoc()
){
?>

<option
value="<?php echo $q['id']; ?>"
>
<?php echo $q["title"]; ?>
</option>

<?php
}
?>

</select>

<button type="submit">
View
</button>

</form>

<hr>

<?php

if($quiz_id != ""){

$attempts =
$model->getQuizAttempts(
    $connection,
    $quiz_id
);

$total = 0;
$count = 0;
$highest = 0;
$lowest = 999999;
$passCount = 0;

?>

<table border="1">

<tr>

<th>Student</th>
<th>Score</th>
<th>Duration</th>
<th>Status</th>

</tr>

<?php

while(
$a = $attempts->fetch_assoc()
){

$start = strtotime($a["started_at"]);

$end = strtotime($a["completed_at"]);

$duration = $end - $start;

$total += $a["score"];

$count++;

if($a["score"] > $highest){

    $highest = $a["score"];
}

if($a["score"] < $lowest){

    $lowest = $a["score"];
}

if($a["score"] >= 60){

    $passCount++;
}

?>

<tr>

<td>
<?php echo $a["name"]; ?>
</td>

<td>
<?php echo $a["score"]; ?>
</td>

<td>
<?php echo $duration; ?> sec
</td>

<td>

<?php

if($a["score"] >= 60){

    echo "PASS";
}
else{

    echo "FAIL";
}
?>

</td>

</tr>

<?php
}
?>

</table>

<hr>

<?php

$average = 0;
$passRate = 0;

if($count > 0){

    $average = $total / $count;

    $passRate =
    ($passCount / $count) * 100;
}
?>

<h3>
Average:
<?php echo $average; ?>
</h3>

<h3>
Highest:
<?php echo $highest; ?>
</h3>

<h3>
Lowest:
<?php echo $lowest; ?>
</h3>

<h3>
Pass Rate:
<?php echo $passRate; ?>%
</h3>

<?php
}
?>

</body>

</html>