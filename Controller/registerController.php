<?php
include("../Model/DatabaseConnection.php");
session_start();
$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$password = trim($_POST["password"]);
$role = $_POST["role"] ?? "";

$hasError = false;

//name
if (empty($name)) {
    $hasError = true;
    $_SESSION["nameError"] = "Name is required";
} 
else if (strlen($name) < 3 ) {
    $hasError = true;
    $_SESSION["nameError"] = "Name must be at least 3 characters";
}

//email
if (empty($email)) {
    $hasError = true;
    $_SESSION["emailError"] = "Email is required";
} else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
    $hasError = true;
    $_SESSION["emailError"] = "Invalid email format";
}
//password
if (empty($password)) {
    $hasError = true;
    $_SESSION["passwordError"] = "Password is required";
} else if (strlen($password) < 8) {
    $hasError = true;
    $_SESSION["passwordError"] = "Password must be at least 8 characters";
}
//role
$avail_role = ["student", "instructor"];

if (empty($role)) {
    $hasError = true;
    $_SESSION["roleError"] = "Invalid role selected";
} else if (!in_array($role, $avail_role)) {
    $hasError = true;
    $_SESSION["roleError"] = "Invalid role selected";
}
if ($hasError) {
    $_SESSION["name"] = $name;
    $_SESSION["email"] = $email;
    $_SESSION["role"] = $role;
    Header("Location:../View/registration.php");
    exit();
} 
else {
    $hasError = false;
    unset($_SESSION["nameError"]);
    unset($_SESSION["emailError"]);
    unset($_SESSION["passwordError"]);
    unset($_SESSION["roleError"]);

    $db = new DatabaseConnection();
    $connection = $db->openConnection();
    $checkEmail =$db->checkEmail($connection,"users",$email);
    if ($checkEmail->num_rows > 0) {

        $_SESSION["emailError"] ="Email already exists";
        $_SESSION["name"] = $name;
        $_SESSION["email"] = $email;
        $_SESSION["role"] = $role;

        Header("Location: ../View/registration.php");
        exit();
    }
    // PASSWORD HASHING
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // INSERT
    $result =$db->signUp($connection,"users",$name, $email,$hashedPassword,$role);

    if ($result) {
        
        unset($_SESSION["name"]);
        unset($_SESSION["email"]);
        unset($_SESSION["role"]);

        Header("Location:../View/login.php");
        exit();
    }
    else {

        $_SESSION["emailError"] ="Registration Failed";

        Header(
            "Location:../View/registration.php"
        );
    }
}


?>