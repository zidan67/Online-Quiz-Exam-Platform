
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
        <script src="../Controller/JSV/register.js"></script>
    </head>

    <body>

        <div class="container">

            <h1>Registration</h1>

            <form method="POST" action="../Controller/registerController.php" onsubmit="return validateReg()">

                <div class="reg">

                    <label>Name</label>

                    <input id="name" type="text" name="name" value="<?php echo $name; ?>">

                    <div class="errorMsg" id="nameError">
                    <?php echo $nameError; ?>
                    </div>

                </div>

                <div class="reg">

                    <label>Email</label>

                    <input id="email" type="email" name="email" value="<?php echo $email; ?>">

                    <div class="errorMsg" id="emailError">
                    <?php echo $emailError; ?>
                    </div>

                </div>

                <div class="reg">

                    <label>Password</label>

                    <input id="password" type="password" name="password">

                    <div class="errorMsg" id="passwordError">
                    <?php echo $passwordError; ?>
                    </div>

                </div>

                <div class="reg">

                    <label>Role</label>

                    <div class="roleType">

                        <label>
                            <input id="role" type="radio" name="role" value="student" <?php if($role =="student"){echo "checked";} ?>> Student
                           
                        </label>

                        <label>
                            <input id="role" type="radio" name="role" value="instructor" <?php if($role =="instructor"){echo "checked";} ?> > Instructor
                        </label>

                    </div>
                        <div class="errorMsg" id="roleError">
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