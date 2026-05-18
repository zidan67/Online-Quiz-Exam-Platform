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
    //Prevent Sql injection
    function signUp($connection, $tableName,$name, $email, $password, $role){
    $sql = "INSERT INTO $tableName (name, email, password_hash,role) VALUES(?,?,?,?)";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ssss", $name ,$email, $password , $role);
        $result = $statement->execute();
        return $result;
    }

    function checkEmail($connection,$tableName, $email){
    $sql ="SELECT * FROM $tableName WHERE email = ?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("s",$email);
        $statement->execute();
        $result = $statement->get_result();
        return $result;
    }

// STUDENT QUIZ COUNT

function getAvailableQuizCount(
    $connection
){

    $sql = "SELECT COUNT(*) AS total
            FROM quizzes
            WHERE status='Published'";

    return $connection->query($sql);
}



// STUDENT SUMMARY

function getStudentSummary($connection,$student_id){
    $sql = "SELECT COUNT(*) AS attempts,IFNULL(SUM(score),0) AS total_score FROM attempts
            WHERE student_id='$student_id'
            AND completed_at IS NOT NULL";

    return $connection->query($sql);
}



// INSTRUCTOR SUMMARY

function getInstructorSummary($connection,$instructor_id){
    $sql = "SELECT COUNT(DISTINCT quizzes.id) AS total_quizzes,
            COUNT(attempts.id) AS total_attempts FROM quizzes
            LEFT JOIN attempts
            ON quizzes.id = attempts.quiz_id

            WHERE quizzes.instructor_id='$instructor_id'";

    return $connection->query($sql);
}

// GET USERS

function getAllUsers($connection){

    $sql = "SELECT * FROM users ORDER BY id DESC";

    return $connection->query($sql);
}

// TOGGLE STATUS

function toggleUserStatus($connection,$id,$status){

    $sql = "UPDATE users SET is_active=? WHERE id=?";
        $statement = $connection->prepare($sql);
        $statement->bind_param("ii",$status,$id);
        $result =$statement->execute();
        return $result;
    return result;
}
}
?>