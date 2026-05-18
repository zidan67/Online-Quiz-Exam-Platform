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
    $_SESSION["role"] != "instructor"
){

    Header(
        "Location: ../login.php"
    );

    exit();
}



$db = new DatabaseConnection();

$connection = $db->openConnection();



// INSTRUCTOR SUMMARY

$summary =
$db->getInstructorSummary(
    $connection,
    $_SESSION["user_id"]
);

$row =
$summary->fetch_assoc();

?>

<!DOCTYPE html>

<html>

<head>

<title>
Instructor Dashboard
</title>

</head>

<body>

<h1>
Instructor Dashboard
</h1>

<h3>
Welcome,
<?php echo $_SESSION["name"]; ?>
</h3>



<h2>

Quizzes Created :

<?php echo $row["total_quizzes"]; ?>

</h2>



<h2>

Total Attempts :

<?php echo $row["total_attempts"]; ?>

</h2>



     <a href="../../Controller/logout.php">

        Logout

    </a>

</body>

</html>