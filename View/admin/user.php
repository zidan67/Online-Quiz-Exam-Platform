<?php

include "../../Model/DatabaseConnection.php";

session_start();

if(
    !isset($_SESSION["isLoggedIn"])
){
    header("Location: ../../login.php");
    exit();
}

if(
    $_SESSION["role"] != "admin"
){
    header("Location: ../../login.php");
    exit();
}

$db = new DatabaseConnection();

$connection = $db->openConnection();

$users =
$db->getAllUsers(
    $connection
);

?>

<!DOCTYPE html>

<html>

<head>

    <title>
        User Management
    </title>

    <script src="js/admin.js"></script>

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
            color:#9333ea;
            font-size:30px;
            font-weight:bold;
            margin-bottom:50px;
            padding-bottom:25px;
            border-bottom:1px solid rgba(255,255,255,0.1);
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
            color:#e5e7eb;
            padding:16px;
            border-radius:12px;
            margin-bottom:10px;
            transition:0.3s;
            font-size:18px;
        }

        .menu a:hover{
            background:rgba(147,51,234,0.2);
        }

        .activeMenu{
            background:rgba(147,51,234,0.3);
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
            height:80px;
            background:white;
            border-bottom:1px solid #e5e7eb;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:0 30px;
        }

        .navbar h1{
            font-size:38px;
            color:#111827;
        }

        .adminName{
            font-size:22px;
            color:#374151;
        }

        .content{
            padding:25px;
        }

        .box{
            background:white;
            border-radius:18px;
            border:1px solid #e5e7eb;
            padding:25px;
        }

        .topSection{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
            padding-bottom:20px;
            border-bottom:1px solid #e5e7eb;
        }

        .topSection h2{
            font-size:40px;
            color:#111827;
            margin-bottom:8px;
        }

        .topSection p{
            font-size:20px;
            color:#6b7280;
        }

        #searchInput{
            width:380px;
            height:52px;
            border:1px solid #d1d5db;
            border-radius:12px;
            padding:0 18px;
            font-size:17px;
            outline:none;
        }

        #searchInput:focus{
            border-color:#9333ea;
        }

        .tableContainer{
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#f3f4f6;
            text-align:left;
            padding:20px;
            font-size:18px;
            color:#111827;
        }

        td{
            padding:22px 20px;
            border-bottom:1px solid #e5e7eb;
            font-size:18px;
            color:#374151;
        }

        .roleBadge{
            padding:8px 14px;
            border-radius:10px;
            font-size:15px;
            font-weight:bold;
        }

        .student{
            background:#dbeafe;
            color:#1456e1;
        }

        .instructor{
            background:#f3e8ff;
            color:#9333ea;
        }

        .admin{
            background:#fef3c7;
            color:#d97706;
        }

        .activeBadge{
            background:#dcfce7;
            color:#16a34a;
            padding:8px 14px;
            border-radius:10px;
            font-size:15px;
            font-weight:bold;
        }

        .inactiveBadge{
            background:#fee2e2;
            color:#dc2626;
            padding:8px 14px;
            border-radius:10px;
            font-size:15px;
            font-weight:bold;
        }

        .activeBtn{
            width:140px;
            height:48px;
            border:1px solid #16a34a;
            background:white;
            color:#16a34a;
            border-radius:10px;
            font-size:16px;
            font-weight:bold;
            cursor:pointer;
        }

        .inactiveBtn{
            width:140px;
            height:48px;
            border:1px solid #dc2626;
            background:white;
            color:#dc2626;
            border-radius:10px;
            font-size:16px;
            font-weight:bold;
            cursor:pointer;
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

                <a href="dashboard.php">

                    <i class="fa-solid fa-house"></i>

                    Dashboard

                </a>

                <a href="#"
                class="activeMenu"
                >

                    <i class="fa-solid fa-users"></i>

                    User Management

                </a>

                <a href="#">

                    <i class="fa-regular fa-rectangle-list"></i>

                    Quizzes

                </a>

                <a href="#">

                    <i class="fa-solid fa-chart-line"></i>

                    Reports

                </a>

                <a href="#">

                    <i class="fa-solid fa-gear"></i>

                    Settings

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

                    User Management

                </h1>

                <div class="adminName">

                    <i class="fa-solid fa-circle-user"></i>

                    <?php echo $_SESSION["name"]; ?>

                </div>

            </div>

            <div class="content">

                <div class="box">

                    <div class="topSection">

                        <div>

                            <h2>
                                All Users
                            </h2>

                            <p>
                                Manage and control user accounts
                            </p>

                        </div>

                        <input
                        type="text"
                        id="searchInput"
                        placeholder="Search by name or email..."
                        onkeyup="searchUser()"
                        >

                    </div>

                    <div class="tableContainer">

                        <table id="userTable">

                            <tr>

                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>

                            <?php

                            $serial = 1;

                            while(
                                $row = $users->fetch_assoc()
                            ){

                            ?>

                            <tr>

                                <td>

                                    <?php echo $serial++; ?>

                                </td>

                                <td>

                                    <?php echo $row["name"]; ?>

                                </td>

                                <td>

                                    <?php echo $row["email"]; ?>

                                </td>

                                <td>

                                    <span

                                    class="roleBadge

                                    <?php

                                    echo $row["role"];

                                    ?>

                                    "

                                    >

                                        <?php echo ucfirst($row["role"]); ?>

                                    </span>

                                </td>

                                <td>

                                    <span

                                    id="status-<?php echo $row["id"]; ?>"

                                    class="<?php echo $row["is_active"] ? "activeBadge" : "inactiveBadge"; ?>"

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

                                <td>

                                    <button

                                    id="btn-<?php echo $row["id"]; ?>"

                                    onclick="toggleUser(
                                        <?php echo $row["id"]; ?>,
                                        <?php echo $row["is_active"]; ?>
                                    )"

                                    class="<?php echo $row["is_active"] ? "activeBtn" : "inactiveBtn"; ?>"

                                    >

                                        <?php

                                        if(
                                            $row["is_active"] == 1
                                        ){
                                            echo "Deactivate";
                                        }

                                        else{
                                            echo "Activate";
                                        }

                                        ?>

                                    </button>

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

    </div>

</body>

</html>