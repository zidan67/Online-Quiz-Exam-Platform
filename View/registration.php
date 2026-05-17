
<?php
session_start();

$emailError = $_SESSION["emailError"] ?? "";
$passwordError = $_SESSION["passwordError"] ?? "";
$nameError = $_SESSION["nameError"] ?? "";
$roleError = $_SESSION["roleError"] ?? "";

$role = $_SESSION["role"] ?? "";
$email = $_SESSION["email"] ?? "";
$name = $_SESSION["name"] ?? "";

unset($_SESSION["roleError"]);
unset($_SESSION["nameError"]);
unset($_SESSION["emailError"]);
unset($_SESSION["passwordError"]);

unset($_SESSION["role"]);
unset($_SESSION["name"]);
unset($_SESSION["email"]);
?>

    <html>

    <head>
        <title>Registration</title>
    </head>

    <body>

        <div class="container">

            <h1>Registration</h1>

            <form method="POST" action="../Controller/registerController.php" >

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
                            <input type="radio" name="role" value="student" <?php if($role =="student"){echo "checked";} ?>> Student
                           
                        </label>

                        <label>
                            <input type="radio" name="role" value="instructor" <?php if($role =="instructor"){echo "checked";} ?> > Instructor
                        </label>

                    </div>
                        <div class="errorMsg">
                        <?php echo $roleError; ?>
                       </div>

                </div>

                <button type="submit">Register</button>

            </form>

            <div class="link">
                <a href="login.php">Already have an account? Login</a>

            </div>

        </div>

    </body>

    </html>