<?php

include "../Model/DatabaseConnection.php";

$id =
$_POST["id"];

$status =
$_POST["status"];

$db =
new DatabaseConnection();

$connection =
$db->openConnection();

// UPDATE STATUS

$db->toggleUserStatus($connection,$id,$status);

// RESPONSE

if($status == 1){

    echo"Active|Deactivate|activeBadge|activeBtn|1";
}

else{

    echo "Inactive|Activate|inactiveBadge|inactiveBtn|0";
}