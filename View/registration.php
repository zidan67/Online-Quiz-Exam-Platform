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

<!DOCTYPE html>
<html>

<head>
    <title>Registration</title>
    <script src="../Controller/JSV/register.js"></script>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background: #f4f6fb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container{
            width: 700px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .header{
            text-align: center;
            margin-bottom: 25px;
        }

        .header img{
            width: 55px;
            height: 55px;
            margin-bottom: 10px;
        }

        .header h1{
            font-size: 28px;
            color: #222;
            margin-bottom: 5px;
        }

        .header p{
            color: #777;
            font-size: 14px;
        }

        .reg{
            margin-bottom: 20px;
        }

        .reg label{
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .reg #name,#password,#email{
            width: 100%;
            padding: 12px;
            border: 1px solid #d0d5dd;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            transition: 0.3s;
        }

    .reg #name:focus,
        #password:focus,
        #email:focus{
        border-color: #2563eb;
        box-shadow: 0 0 4px rgba(37,99,235,0.3);
        }

        .errorMsg{
            color: red;
            font-size: 13px;
            margin-top: 5px;
        }

        .roleType{
            display: flex;
            gap: 15px;
        }

        .roleBox{
            flex: 1;
            border: 1px solid #d0d5dd;
            border-radius: 10px;
            padding: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .roleBox:hover{
            border-color: #2563eb;
            background: #f8fbff;
        }

        .roleBox input{
            padding-bottom: 10%;
        }

        .roleTitle{
            padding-left: 10%;
            font-weight: bold;
            color: #222;
            margin-bottom: 7px;
        }

        .roleDesc{

            padding-left:10%;
            font-size: 10px;
            color: #666;
        }

        button{
            width: 100%;
            padding: 13px;
            background: #2563eb;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover{
            background: #1d4ed8;
        }

        .link{
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
        }

        .link a{
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        .link a:hover{
            text-decoration: underline;
        }

    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <img src="../image/1.png" alt="register image">
            <h1>Create Your Account</h1>
            <p>Register to get started</p>
        </div>

        <form method="POST" action="../Controller/registerController.php" onsubmit="return validateReg()">

            <div class="reg">

                <label>Name *</label>
                <input id="name" type="text" name="name" placeholder="Enter your name" value="<?php echo $name; ?>">

                <div class="errorMsg" id="nameError">
                    <?php echo $nameError; ?>
                </div>

            </div>

            <div class="reg">

                <label>Email Address *</label>

                <input id="email" type="email" name="email"
                    placeholder="Enter your email address"
                    value="<?php echo $email; ?>">

                <div class="errorMsg" id="emailError">
                    <?php echo $emailError; ?>
                </div>

            </div>

            <div class="reg">

                <label>Password *</label>

                <input id="password" type="password" name="password"
                    placeholder="Enter your password">

                <div class="errorMsg" id="passwordError">
                    <?php echo $passwordError; ?>
                </div>

            </div>

            <div class="reg">

                <label>Select Your Role *</label>

                <div class="roleType">

                    <label class="roleBox">

                        <input type="radio" name="role" value="student"
                        <?php if($role =="student"){echo "checked";} ?>>

                        <div class="roleTitle">Student</div>
                        <div class="roleDesc">
                            Access quizzes and track your progress
                        </div>

                    </label>

                    <label class="roleBox">

                        <input style="margin-bottom: 0px;" type="radio" name="role" value="instructor"
                        <?php if($role =="instructor"){echo "checked";} ?>>

                        <div class="roleTitle">Instructor</div>
                        <div class="roleDesc">
                            Create quizzes and manage content
                        </div>

                    </label>

                </div>

                <div class="errorMsg" id="roleError">
                    <?php echo $roleError; ?>
                </div>

            </div>

            <button type="submit">Register</button>

        </form>

        <div class="link">
            Already have an account?
            <a href="login.php">Login here</a>
        </div>

    </div>

</body>

</html>