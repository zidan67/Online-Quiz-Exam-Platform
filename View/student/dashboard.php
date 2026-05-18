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
    $_SESSION["role"] != "student"
){

    Header(
        "Location: ../login.php"
    );

    exit();
}

$db = new DatabaseConnection();

$connection = $db->openConnection();



// QUIZ COUNT

$quizResult =
$db->getAvailableQuizCount(
    $connection
);

$quizRow =
$quizResult->fetch_assoc();



// STUDENT SUMMARY

$summary =
$db->getStudentSummary(
    $connection,
    $_SESSION["user_id"]
);

$summaryRow =
$summary->fetch_assoc();

?>

<!DOCTYPE html>

<html>

<head>

    <title>
        Student Dashboard
    </title>

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            background:#f5f7fb;
            display:flex;
        }

        .sidebar{
            width:250px;
            height:100vh;
            background:white;
            border-right:1px solid #e5e7eb;
            padding:25px 20px;
            position:fixed;
        }

        .logo{
            display:flex;
            align-items:center;
            gap:12px;
            font-size:30px;
            color:#1456e1;
            font-weight:bold;
            margin-bottom:50px;
        }

        .menu a{
            display:flex;
            align-items:center;
            gap:14px;
            text-decoration:none;
            color:#374151;
            padding:16px;
            border-radius:12px;
            margin-bottom:10px;
            transition:0.3s;
            font-size:18px;
        }

        .menu a:hover{
            background:#edf4ff;
            color:#1456e1;
        }

        .active{
            background:#edf4ff;
            color:#1456e1 !important;
        }

        .logout{
            position:absolute;
            bottom:30px;
            width:84%;
        }

        .logout a{
            color:red;
        }

        .main{
            margin-left:250px;
            width:100%;
        }

        .topbar{
            height:80px;
            background:white;
            border-bottom:1px solid #e5e7eb;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 30px;
        }

        .topbar h1{
            font-size:36px;
            color:#111827;
        }

        .profile{
            font-size:20px;
            color:#374151;
        }

        .content{
            padding:30px;
        }

        .welcome h2{
            font-size:38px;
            margin-bottom:10px;
            color:#111827;
        }

        .welcome p{
            color:#6b7280;
            font-size:20px;
            margin-bottom:30px;
        }

        .cards{
            display:flex;
            gap:25px;
            flex-wrap:wrap;
        }

        .card{
            flex:1;
            min-width:280px;
            background:white;
            border-radius:18px;
            padding:25px;
            border:1px solid #e5e7eb;
            display:flex;
            gap:20px;
            align-items:center;
        }

        .icon{
            width:90px;
            height:90px;
            border-radius:18px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:42px;
        }

        .blue{
            background:#dbeafe;
            color:#1456e1;
        }

        .green{
            background:#dcfce7;
            color:#16a34a;
        }

        .purple{
            background:#f3e8ff;
            color:#9333ea;
        }

        .cardInfo h3{
            font-size:24px;
            margin-bottom:10px;
        }

        .cardInfo h1{
            font-size:42px;
            margin-bottom:8px;
            color:#111827;
        }

        .cardInfo p{
            color:#6b7280;
            font-size:17px;
        }

        .quizSection{
            background:white;
            margin-top:30px;
            border-radius:18px;
            border:1px solid #e5e7eb;
            padding:25px;
        }

        .quizTop{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        .quizTop h2{
            font-size:32px;
            color:#111827;
        }

        .quizTop a{
            text-decoration:none;
            border:1px solid #1456e1;
            color:#1456e1;
            padding:12px 22px;
            border-radius:10px;
            font-size:17px;
        }

        .empty{
            text-align:center;
            padding:60px 20px;
        }

        .empty i{
            font-size:70px;
            color:#cbd5e1;
            margin-bottom:20px;
        }

        .empty h3{
            font-size:28px;
            margin-bottom:10px;
            color:#111827;
        }

        .empty p{
            color:#6b7280;
            font-size:18px;
        }

    </style>

</head>

<body>

    <div class="sidebar">

        <div class="logo">

            <i class="fa-solid fa-graduation-cap"></i>

            Quiz Platform

        </div>

        <div class="menu">

            <a href="#" class="active">

                <i class="fa-solid fa-house"></i>

                Dashboard

            </a>

            <a href="#">

                <i class="fa-regular fa-rectangle-list"></i>

                Available Quizzes

            </a>

            <a href="#">

                <i class="fa-solid fa-clock-rotate-left"></i>

                My Attempts

            </a>

            <a href="#">

                <i class="fa-regular fa-user"></i>

                Profile

            </a>

        </div>

        <div class="logout menu">

            <a href="../../Controller/logout.php">

                <i class="fa-solid fa-arrow-right-from-bracket"></i>

                Logout

            </a>

        </div>

    </div>

    <div class="main">

        <div class="topbar">

            <h1>

                Student Dashboard

            </h1>

            <div class="profile">

                <i class="fa-solid fa-circle-user"></i>

                <?php echo $_SESSION["name"]; ?>

            </div>

        </div>

        <div class="content">

            <div class="welcome">

                <h2>

                    Welcome back,
                    <?php echo $_SESSION["name"]; ?>! 👋

                </h2>

                <p>

                    Here's your overview and quiz activity.

                </p>

            </div>

            <div class="cards">

                <div class="card">

                    <div class="icon blue">

                        <i class="fa-solid fa-book-open"></i>

                    </div>

                    <div class="cardInfo">

                        <h3>
                            Quizzes Available
                        </h3>

                        <h1>
                            <?php echo $quizRow["total"]; ?>
                        </h1>

                        <p>
                            Published quizzes ready to attempt
                        </p>

                    </div>

                </div>

                <div class="card">

                    <div class="icon green">

                        <i class="fa-regular fa-clipboard"></i>

                    </div>

                    <div class="cardInfo">

                        <h3>
                            Attempts Taken
                        </h3>

                        <h1>
                            <?php echo $summaryRow["attempts"]; ?>
                        </h1>

                        <p>
                            Total quizzes you have attempted
                        </p>

                    </div>

                </div>

                <div class="card">

                    <div class="icon purple">

                        <i class="fa-solid fa-trophy"></i>

                    </div>

                    <div class="cardInfo">

                        <h3>
                            Total Score Earned
                        </h3>

                        <h1>
                            <?php echo $summaryRow["total_score"]; ?>
                        </h1>

                        <p>
                            Marks obtained across all attempts
                        </p>

                    </div>

                </div>

            </div>

            <div class="quizSection">

                <div class="quizTop">

                    <h2>
                        Available Quizzes
                    </h2>

                    <a href="#">
                        View All
                    </a>

                </div>

                <div class="empty">

                    <i class="fa-regular fa-file-lines"></i>

                    <h3>
                        No quizzes available right now.
                    </h3>

                    <p>
                        Check back later for new quizzes.
                    </p>

                </div>

            </div>

        </div>

    </div>

</body>

</html>