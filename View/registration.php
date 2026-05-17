<?php
session_start();

$emailError = $_SESSION["emailError"] ?? "";
$passwordError = $_SESSION["passwordError"] ?? "";
$nameError = $_SESSION["nameError"] ?? "";

$email = $_SESSION["email"] ?? "";
$name = $_SESSION["name"] ?? "";

unset($_SESSION["nameError"]);
unset($_SESSION["emailError"]);
unset($_SESSION["passwordError"]);
unset($_SESSION["name"]);
unset($_SESSION["email"]);
?>

    <html>

    <head>
        <title>Registration</title>
    </head>

    <body>

        <div class="container">

            <h1>Register</h1>

            <form action="../controllers/RegisterController.php" method="POST">

                <div class="reg">

                    <label>Name</label>

                    <input type="text" name="name" value="<?php echo $name; ?>">

                    <div class="errorMsg">
                    <?php echo $nameError; ?>
                    </div>

                </div>

                <div class="reg">

                    <label>Email</label>

                    <input type="email" name="email" value="<?php echo $email; ?>">

                    <div class="errorMsg">
                    <?php echo $emailError; ?>
                    </div>

                </div>

                <div class="reg">

                    <label>Password</label>

                    <input type="password" name="password">

                    <div class="errorMsg">
                    <?php echo $passwordError; ?>
                    </div>

                </div>

                <div class="reg">

                    <label>Role</label>

                    <div class="roleType">

                        <label>
                            <input type="radio" name="role" value="student" checked> Student
                        </label>

                        <label>
                            <input type="radio" name="role" value="instructor"> Instructor
                        </label>

                    </div>

                </div>

                <button type="submit">
                    Register
                </button>

            </form>

            <div class="link">
                <a href="login.php">Already have an account? Login</a>

            </div>

        </div>

    </body>

    </html>