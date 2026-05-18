<?php

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
    $_SESSION["role"] != "admin"
){

    Header(
        "Location: ../login.php"
    );

    exit();
}

?>

<!DOCTYPE html>

<html>

<head>

<title>
Admin Dashboard
</title>

</head>

<body>

<h1>
Admin Panel
</h1>

<h3>
Welcome,
<?php echo $_SESSION["name"]; ?>
</h3>

<a href="user.php">

Manage Users

</a>



    <a href="../Controller/logout.php">

        Logout

    </a>

</body>

</html>