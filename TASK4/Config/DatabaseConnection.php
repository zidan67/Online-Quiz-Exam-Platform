<?php

class DatabaseConnection{

    function openConnection(){

        $host = "localhost";

        $username = "root";

        $password = "";

        $database = "online_quiz_platform";



        $connection =
        new mysqli(
            $host,
            $username,
            $password,
            $database
        );



        if(
            $connection->connect_error
        ){

            die(
                "Database Connection Failed: "
                .
                $connection->connect_error
            );
        }



        return $connection;
    }
}
?>