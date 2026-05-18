<?php

include "../../Model/DatabaseConnection.php";

session_start();

if(
    !isset($_SESSION["isLoggedIn"])
){

    Header(
        "Location: ../login.php"
    );

    exit();
}



if(
    $_SESSION["role"] != "student"
){

    Header(
        "Location: ../login.php"
    );

    exit();
}



$db = new DatabaseConnection();

$connection = $db->openConnection();



// QUIZ COUNT

$quizResult =
$db->getAvailableQuizCount(
    $connection
);

$quizRow =
$quizResult->fetch_assoc();



// STUDENT SUMMARY

$summary =
$db->getStudentSummary(
    $connection,
    $_SESSION["user_id"]
);

$summaryRow =
$summary->fetch_assoc();

?>

<!DOCTYPE html>

<html>

<head>

<title>
Student Dashboard
</title>

</head>

<body>

<h1>
Student Dashboard
</h1>

<h3>
Welcome,
<?php echo $_SESSION["name"]; ?>
</h3>



<h2>

Available Quizzes :

<?php echo $quizRow["total"]; ?>

</h2>



<h2>

Total Attempts :

<?php echo $summaryRow["attempts"]; ?>

</h2>



<h2>

Total Score :

<?php echo $summaryRow["total_score"]; ?>

</h2>

<a href="../../Controller/logout.php">
    Logout
</a>

</body>

</html>