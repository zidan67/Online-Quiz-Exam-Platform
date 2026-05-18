<?php

include "../../Model/DatabaseConnection.php";

session_start();

if (!isset($_SESSION["isLoggedIn"])) {
    header("Location:../../login.php");
    exit();
}

if ($_SESSION["role"] != "admin") {
    header("Location:../../login.php");
    exit();
}

$db = new DatabaseConnection();

$connection = $db->openConnection();

$users = $db->getAllUsers($connection);

?>

<!DOCTYPE html>

<html>

<head>

    <title>User Management</title>

    <script src="js/admin.js"></script>

    <link rel="stylesheet" href="admin.css">

</head>

<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <h2>Quiz Platform</h2>

        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="activeMenu"><a href="user.php">User Management</a></li>
            <li>
            <a href="../../Controller/logout.php">Logout</a>
            </li>
        </ul>

    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- NAVBAR -->
        <div class="navbar">

            <h1>User Management</h1>

            <div class="adminName">
                <?php echo $_SESSION["name"]; ?>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="content">

            <!-- TOP SECTION -->
            <div class="topSection">

                <div>
                    <h2>All Users</h2>
                    <p>Manage and control users.</p>
                </div>

                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="Search by name or email"
                    onkeyup="searchUser()"
                >

            </div>

            <!-- TABLE -->
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

                    while ($row = $users->fetch_assoc()) {

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

                            <span class="roleBadge">
                                <?php echo $row["role"]; ?>
                            </span>

                        </td>

                        <td>

                            <span 
                                id="status-<?php echo $row["id"]; ?>"
                                class="<?php echo $row["is_active"] ? "activeBadge" : "inactiveBadge"; ?>"
                            >

                                <?php

                                if ($row["is_active"] == 1) {
                                    echo "Active";
                                } 
                                
                                else {
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

                                if ($row["is_active"] == 1) {
                                    echo "Deactivate";
                                } 
                                
                                else {
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

</body>

</html>