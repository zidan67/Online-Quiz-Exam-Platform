<?php 

class DatabaseConnection{
    function openConnection(){
        $db_host = "localhost"; 
        $db_user = "root";
        $db_password = "";
        $db_name = "online_quiz_platform";

        $connection = new mysqli($db_host,$db_user, $db_password, $db_name);
        if($connection->connect_error){
            die("Could not connect to the database- ". $connection->connect_error);
        }

    return $connection;
    }
    function signUp($connection, $tableName,$name, $email, $password, $role){
    $sql = "INSERT INTO $tableName (name, email, password_hash,role) VALUES('".$name."', '".$email."' , '".$password."', '".$role."')";
    $result = $connection->query($sql);
    return $result;
    }

    function checkEmail($connection,$tableName, $email){
    $sql ="SELECT * FROM $tableName WHERE email = '$email'";
    $result = $connection->query($sql);
    return $result;
    }

}

?>