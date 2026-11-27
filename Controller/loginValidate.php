<?php
include("../Model/DatabaseConnection.php");
session_start();
$email = $_POST["email"];
$password = $_POST["password"];
$hasEmailError = false;
$hasPasswordError = false;

if(empty($email)){
    $hasEmailError = true;
    $_SESSION["emailError"] = "Email is required";
}
else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $hasEmailError = true;
    $_SESSION["emailError"] = "Invalid email format";
}
else{
    $hasEmailError = false;
    unset($_SESSION["emailError"]);
}
if(empty($password)){
    $hasPasswordError = true;
    $_SESSION["passwordError"] = "Password is required";
}
else{
    $hasPasswordError = false;
    unset($_SESSION["passwordError"]);
}
if($hasEmailError || $hasPasswordError){
    $_SESSION["email"] = $email;
    Header("Location:../View/login.php");
    exit();
}
else{
    unset($_SESSION["loggingError"]);
    $isLoggedIn = false;
    $db = new DatabaseConnection();
    $connection = $db->openConnection();
    $result = $db-> checkEmail($connection, "users", $email);
    if($result->num_rows == 1){
        while($row = $result->fetch_assoc()){
        //Active or not
        if($row["is_active"] == 0){
        $_SESSION["loggingError"] = "Your account has been suspended.";
        Header("Location:../View/login.php");
        exit();
        }
        //hashpasswordverify
        if(password_verify($password, $row["password_hash"])){
           $isLoggedIn = true;
           $_SESSION["isLoggedIn"] = true;
           $_SESSION["user_id"] = $row["id"];
           $_SESSION["name"] = $row["name"];
           $_SESSION["role"] = $row["role"];
        //role

            if($row["role"] == "student"){
            Header("Location:../View/student/dashboard.php");
            exit();
            }

            else if($row["role"] == "instructor")
            {
                Header("Location:../View/instructor/dashboard.php");
                exit();
            }

            else if($row["role"] == "admin"){
            Header("Location:../View/admin/dashboard.php");    
            exit();
            }
        }
        
    }
}
}
    if(!$isLoggedIn){
        $_SESSION["email"] = $email;
        $_SESSION["loggingError"] = "Email or password is incorrect!";
        Header("Location: ../View/login.php");
        exit();
    }
    

?>