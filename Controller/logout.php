<?php

session_start();

session_unset();

session_destroy();

Header("Location: ../View/login.php");

exit();

?>