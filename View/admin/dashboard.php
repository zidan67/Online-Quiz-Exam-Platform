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
    $_SESSION["role"] != "admin"
){

    Header(
        "Location: ../login.php"
    );

    exit();
}

$db = new DatabaseConnection();

$connection =
$db->openConnection();



// TOTAL USERS

$totalUsersResult =
$db->getTotalUsers($connection
);

$totalUsersRow =
$totalUsersResult->fetch_assoc();



// ACTIVE USERS

$activeUsersResult =
$db->getActiveUsers(
    $connection
);

$activeUsersRow =
$activeUsersResult->fetch_assoc();



// TOTAL STUDENTS

$studentResult =
$db->getTotalStudents(
    $connection
);

$studentRow =
$studentResult->fetch_assoc();



// TOTAL INSTRUCTORS

$instructorResult =
$db->getTotalInstructors(
    $connection
);

$instructorRow =
$instructorResult->fetch_assoc();



// RECENT USERS

$recentUsers =
$db->getRecentUsers(
    $connection
);

?>

<!DOCTYPE html>

<html>

<head>

    <title>
        Admin Dashboard
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
        }

        .dashboard{
            display:flex;
        }

        .sidebar{
            width:250px;
            height:100vh;
            background:linear-gradient(
                180deg,
                #0f172a,
                #111827,
                #172554
            );

            padding:25px 20px;
            position:fixed;
        }

        .logo{
            display:flex;
            align-items:center;
            gap:12px;
            color:white;
            font-size:28px;
            font-weight:bold;
            margin-bottom:50px;
            padding-bottom:25px;
            border-bottom:1px solid rgba(255,255,255,0.1);
        }

        .logo i{
            color:#9333ea;
        }

        .menuTitle{
            color:#d1d5db;
            font-size:15px;
            margin-bottom:20px;
        }

        .menu a{
            display:flex;
            align-items:center;
            gap:14px;
            text-decoration:none;
            color:#f3f4f6;
            padding:16px;
            border-radius:12px;
            margin-bottom:10px;
            transition:0.3s;
            font-size:18px;
        }

        .menu a:hover{
            background:rgba(147,51,234,0.25);
        }

        .activeMenu{
            background:rgba(147,51,234,0.35);
        }

        .logout{
            position:absolute;
            bottom:30px;
            width:84%;
        }

        .logout a{
            color:#ff4d4f;
        }

        .main{
            margin-left:250px;
            width:100%;
        }

        .navbar{
            height:90px;
            background:white;
            border-bottom:1px solid #e5e7eb;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:0 35px;
        }

        .navbar h1{
            font-size:42px;
            color:#111827;
        }

        .adminName{
            font-size:22px;
            color:#374151;
        }

        .content{
            padding:30px;
        }

        .cards{
            display:flex;
            gap:25px;
            flex-wrap:wrap;
            margin-bottom:30px;
        }

        .card{
            flex:1;
            min-width:250px;
            background:white;
            border-radius:18px;
            border:1px solid #e5e7eb;
            padding:28px;
            text-decoration:none;
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-5px);
            box-shadow:0 8px 20px rgba(0,0,0,0.06);
        }

        .cardTop{
            display:flex;
            align-items:center;
            gap:18px;
            margin-bottom:25px;
        }

        .cardIcon{
            width:82px;
            height:82px;
            border-radius:18px;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:38px;
        }

        .purple{
            background:#ede9fe;
            color:#7c3aed;
        }

        .green{
            background:#dcfce7;
            color:#16a34a;
        }

        .blue{
            background:#dbeafe;
            color:#2563eb;
        }

        .orange{
            background:#ffedd5;
            color:#ea580c;
        }

        .cardInfo h3{
            font-size:22px;
            color:#64748b;
            margin-bottom:10px;
        }

        .cardInfo h1{
            font-size:52px;
            color:#111827;
        }

        .card p{
            margin-top:12px;
            font-size:18px;
            font-weight:bold;
        }

        .purpleText{
            color:#7c3aed;
        }

        .greenText{
            color:#16a34a;
        }

        .blueText{
            color:#2563eb;
        }

        .orangeText{
            color:#ea580c;
        }

        .tableBox{
            background:white;
            border-radius:18px;
            border:1px solid #e5e7eb;
            overflow:hidden;
        }

        .tableTop{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:25px;
            border-bottom:1px solid #e5e7eb;
        }

        .tableTop h2{
            font-size:32px;
            color:#111827;
        }

        .viewBtn{
            text-decoration:none;
            background:#ede9fe;
            color:#7c3aed;
            padding:10px 16px;
            border-radius:10px;
            font-weight:bold;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#f8fafc;
            padding:18px;
            text-align:left;
            font-size:17px;
            color:#111827;
        }

        td{
            padding:20px 18px;
            border-bottom:1px solid #f1f5f9;
            font-size:17px;
            color:#475569;
        }

        .badge{
            padding:8px 14px;
            border-radius:10px;
            font-size:14px;
            font-weight:bold;
        }

        .student{
            background:#dbeafe;
            color:#2563eb;
        }

        .instructor{
            background:#ede9fe;
            color:#7c3aed;
        }

        .admin{
            background:#fef3c7;
            color:#d97706;
        }

        .active{
            background:#dcfce7;
            color:#16a34a;
        }

        .inactive{
            background:#fee2e2;
            color:#dc2626;
        }

    </style>

</head>

<body>

    <div class="dashboard">

        <div class="sidebar">

            <div class="logo">

                <i class="fa-solid fa-shield-halved"></i>

                Quiz Platform

            </div>

            <div class="menuTitle">

                ADMIN PANEL

            </div>

            <div class="menu">

                <a href="dashboard.php"
                class="activeMenu"
                >

                    <i class="fa-solid fa-house"></i>

                    Dashboard

                </a>

                <a href="user.php">

                    <i class="fa-solid fa-users"></i>

                    User Management

                </a>

                <a href="#">

                    <i class="fa-regular fa-rectangle-list"></i>

                    Quizzes

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

            <div class="navbar">

                <h1>

                    Dashboard

                </h1>

                <div class="adminName">

                    <i class="fa-solid fa-circle-user"></i>

                    <?php echo $_SESSION["name"]; ?>

                </div>

            </div>

            <div class="content">

                <div class="cards">

                    <a
                    href="user.php"
                    class="card"
                    >

                        <div class="cardTop">

                            <div class="cardIcon purple">

                                <i class="fa-solid fa-users"></i>

                            </div>

                            <div class="cardInfo">

                                <h3>
                                    Total Users
                                </h3>

                                <h1>

                                    <?php echo $totalUsersRow["total"]; ?>

                                </h1>

                            </div>

                        </div>

                        <p class="purpleText">

                            View all users →

                        </p>

                    </a>

                    <a
                    href="user.php"
                    class="card"
                    >

                        <div class="cardTop">

                            <div class="cardIcon green">

                                <i class="fa-solid fa-user-check"></i>

                            </div>

                            <div class="cardInfo">

                                <h3>
                                    Active Users
                                </h3>

                                <h1>

                                    <?php echo $activeUsersRow["total"]; ?>

                                </h1>

                            </div>

                        </div>

                        <p class="greenText">

                            View active users →

                        </p>

                    </a>

                    <a
                    href="user.php"
                    class="card"
                    >

                        <div class="cardTop">

                            <div class="cardIcon blue">

                                <i class="fa-solid fa-graduation-cap"></i>

                            </div>

                            <div class="cardInfo">

                                <h3>
                                    Students
                                </h3>

                                <h1>

                                    <?php echo $studentRow["total"]; ?>

                                </h1>

                            </div>

                        </div>

                        <p class="blueText">

                            View students →

                        </p>

                    </a>

                    <a
                    href="user.php"
                    class="card"
                    >

                        <div class="cardTop">

                            <div class="cardIcon orange">

                                <i class="fa-solid fa-user-tie"></i>

                            </div>

                            <div class="cardInfo">

                                <h3>
                                    Instructors
                                </h3>

                                <h1>

                                    <?php echo $instructorRow["total"]; ?>

                                </h1>

                            </div>

                        </div>

                        <p class="orangeText">

                            View instructors →

                        </p>

                    </a>

                </div>

                <div class="tableBox">

                    <div class="tableTop">

                        <h2>

                            Recent Users

                        </h2>

                        <a
                        href="user.php"
                        class="viewBtn"
                        >

                            View all

                        </a>

                    </div>

                    <table>

                        <tr>

                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>

                        </tr>

                        <?php

                        while(
                            $row = $recentUsers->fetch_assoc()
                        ){

                        ?>

                        <tr>

                            <td>

                                <?php echo $row["name"]; ?>

                            </td>

                            <td>

                                <?php echo $row["email"]; ?>

                            </td>

                            <td>

                                <span

                                class="badge

                                <?php echo $row["role"]; ?>

                                "

                                >

                                    <?php echo ucfirst($row["role"]); ?>

                                </span>

                            </td>

                            <td>

                                <span

                                class="badge

                                <?php

                                if(
                                    $row["is_active"] == 1
                                ){
                                    echo "active";
                                }

                                else{
                                    echo "inactive";
                                }

                                ?>

                                "

                                >

                                    <?php

                                    if(
                                        $row["is_active"] == 1
                                    ){
                                        echo "Active";
                                    }

                                    else{
                                        echo "Inactive";
                                    }

                                    ?>

                                </span>

                            </td>

                        </tr>

                        <?php

                        }

                        ?>

                    </table>

                </div>

            </div>

        </div>

    </div>

</body>

</html>