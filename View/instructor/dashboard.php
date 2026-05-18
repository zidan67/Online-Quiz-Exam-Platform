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
    $_SESSION["role"] != "instructor"
){

    Header(
        "Location: ../login.php"
    );

    exit();
}

$db = new DatabaseConnection();

$connection = $db->openConnection();



// INSTRUCTOR SUMMARY

$summary =
$db->getInstructorSummary(
    $connection,
    $_SESSION["user_id"]
);

$row =
$summary->fetch_assoc();

?>

<!DOCTYPE html>

<html>

<head>

    <title>
        Instructor Dashboard
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
            color:#9333ea;
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
            background:#f3e8ff;
            color:#9333ea;
        }

        .active{
            background:#f3e8ff;
            color:#9333ea !important;
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

        .purple{
            background:#f3e8ff;
            color:#9333ea;
        }

        .orange{
            background:#ffedd5;
            color:#ea580c;
        }

        .green{
            background:#dcfce7;
            color:#16a34a;
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

        .rightButtons{
            display:flex;
            gap:15px;
        }

        .viewBtn{
            text-decoration:none;
            border:1px solid #9333ea;
            color:#9333ea;
            padding:12px 22px;
            border-radius:10px;
            font-size:17px;
        }

        .createBtn{
            text-decoration:none;
            background:#9333ea;
            color:white;
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

            <i class="fa-solid fa-chalkboard-user"></i>

            Quiz Platform

        </div>

        <div class="menu">

            <a href="#" class="active">

                <i class="fa-solid fa-house"></i>

                Dashboard

            </a>

            <a href="#">

                <i class="fa-regular fa-rectangle-list"></i>

                My Quizzes

            </a>

            <a href="#">

                <i class="fa-solid fa-square-plus"></i>

                Create Quiz

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

                Instructor Dashboard

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

                    Here's an overview of your quizzes and activity.

                </p>

            </div>

            <div class="cards">

                <div class="card">

                    <div class="icon purple">

                        <i class="fa-regular fa-clipboard"></i>

                    </div>

                    <div class="cardInfo">

                        <h3>
                            Quizzes Created
                        </h3>

                        <h1>
                            <?php echo $row["total_quizzes"]; ?>
                        </h1>

                        <p>
                            Total quizzes you have created
                        </p>

                    </div>

                </div>

                <div class="card">

                    <div class="icon orange">

                        <i class="fa-solid fa-users"></i>

                    </div>

                    <div class="cardInfo">

                        <h3>
                            Total Attempts
                        </h3>

                        <h1>
                            <?php echo $row["total_attempts"]; ?>
                        </h1>

                        <p>
                            Attempts across all your quizzes
                        </p>

                    </div>

                </div>

                <div class="card">

                    <div class="icon green">

                        <i class="fa-solid fa-chart-line"></i>

                    </div>

                    <div class="cardInfo">

                        <h3>
                            Active Quizzes
                        </h3>

                        <h1>
                            <?php echo $row["total_quizzes"]; ?>
                        </h1>

                        <p>
                            Quizzes currently published
                        </p>

                    </div>

                </div>

            </div>

            <div class="quizSection">

                <div class="quizTop">

                    <h2>
                        Your Recent Quizzes
                    </h2>

                    <div class="rightButtons">

                        <a href="#" class="viewBtn">
                            View All
                        </a>

                        <a href="#" class="createBtn">
                            + Create Quiz
                        </a>

                    </div>

                </div>

                <div class="empty">

                    <i class="fa-regular fa-file-lines"></i>

                    <h3>
                        You haven't created any quizzes yet.
                    </h3>

                    <p>
                        Create your first quiz to get started.
                    </p>

                </div>

            </div>

        </div>

    </div>

</body>

</html>