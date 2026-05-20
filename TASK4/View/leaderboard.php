<?php

include "../Config/DatabaseConnection.php";
include "../Model/QuizModel.php";

$db = new DatabaseConnection();

$connection = $db->openConnection();

$model = new QuizModel();

$leaders =
$model->getLeaderboard(
    $connection
);

?>

<!DOCTYPE html>

<html>

<head>

<style>

body{

    font-family: Arial;
}



table{

    width: 100%;

    border-collapse: collapse;

    margin-top: 20px;

    background-color: white;
}



th{

    background-color: #333;

    color: white;

    padding: 12px;
}



td{

    border: 1px solid #ccc;

    padding: 10px;

    text-align: center;
}



tr:nth-child(even){

    background-color: #f9f9f9;
}

</style>

</head>

<body>

<table>

<tr>

<th>Rank</th>
<th>Name</th>
<th>Total Score</th>

</tr>

<?php

$rank = 1;

while(
$l = $leaders->fetch_assoc()
){
?>

<tr>

<td>
<?php echo $rank; ?>
</td>

<td>
<?php echo $l["name"]; ?>
</td>

<td>
<?php echo $l["total_score"]; ?>
</td>

</tr>

<?php

$rank++;
}
?>

</table>

</body>

</html>