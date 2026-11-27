<?php

include "../../Config/DatabaseConnection.php";
include "../../Model/QuizModel.php";

session_start();

$student_id = 116;

$db = new DatabaseConnection();

$connection = $db->openConnection();

$model = new QuizModel();

$results =
$model->getStudentResults(
    $connection,
    $student_id
);

?>

<!DOCTYPE html>

<html>

<head>

<title>
My Results
</title>

<style>

body{

    font-family: Arial;

    background-color: #f4f4f4;

    padding: 20px;
}



h1{

    text-align: center;

    margin-bottom: 20px;
}



table{

    width: 100%;

    border-collapse: collapse;

    background-color: white;
}



th{

    background-color: #333;

    color: white;

    padding: 12px;
}



td{

    padding: 10px;

    text-align: center;

    border: 1px solid #ccc;
}



tr:nth-child(even){

    background-color: #f9f9f9;
}



.pass{

    color: green;

    font-weight: bold;
}



.fail{

    color: red;

    font-weight: bold;
}

</style>

</head>

<body>

<h1>
My Results
</h1>

<table border="1">

<tr>

<th>Quiz</th>
<th>Score</th>
<th>Date</th>
<th>Duration</th>
<th>Status</th>

</tr>

<?php

while(
$r = $results->fetch_assoc()
){

$start = strtotime($r["started_at"]);

$end = strtotime($r["completed_at"]);

$duration = $end - $start;

?>

<tr>

<td>
<?php echo $r["title"]; ?>
</td>

<td>
<?php echo $r["score"]; ?>
</td>

<td>
<?php echo $r["completed_at"]; ?>
</td>

<td>
<?php echo $duration; ?> sec
</td>

<td>

<?php

if($r["score"] >= 60){
?>

<span class="pass">
PASS
</span>

<?php
}
else{
?>

<span class="fail">
FAIL
</span>

<?php
}
?>

</td>

</tr>

<?php
}
?>

</table>

</body>

</html>