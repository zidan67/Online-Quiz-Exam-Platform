<?php
function requireInstructor()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "instructor") {
        $script = str_replace("\\", "/", $_SERVER["SCRIPT_NAME"] ?? "");
        $folder = "/Online-Quiz-Exam-Platform";
        $pos = strpos($script, $folder);
        $baseUrl = $pos === false ? "" : substr($script, 0, $pos + strlen($folder));
        header("Location: ../../View/login.php");
        exit;
    }
}
?>