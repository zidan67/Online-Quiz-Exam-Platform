<?php

session_start();

$emailError = $_SESSION["emailError"] ?? "";
$passwordError = $_SESSION["passwordError"] ?? "";
$loginError = $_SESSION["loggingError"] ?? "";
$email = $_SESSION["email"] ?? "";
$isLoggedIn = $_SESSION["isLoggedIn"];

if(isset($_SESSION["isLoggedIn"])){

    if($_SESSION["role"] == "student"){
        Header("Location: student/dashboard.php");
        exit();
    }
    else if($_SESSION["role"] == "instructor"){
        Header("Location: instructor/dashboard.php");
        exit();
    }

    else if($_SESSION["role"] == "admin"){
        Header("Location: admin/dashboard.php");
        exit();
    }
}

unset($_SESSION["emailError"]);
unset($_SESSION["passwordError"]);
unset($_SESSION["loggingError"]);
unset($_SESSION["email"]);

?>
<html>
  <head>
    <title>Login</title>
  </head>
  <body>
    <div class="container">
      <h1>Login</h1>
      <form action="../Controller/loginValidate.php" method="POST">
        <div class="reg">
          <label>Email</label>
          <input type="email" name="email" value="<?php echo $email; ?>">

          <div class="errorMsg"> <?php echo $emailError; ?> </div>
        </div>
        <div class="reg">
          <label>Password</label>
          <input type="password" name="password">
          <div class="errorMsg"> <?php echo $passwordError; ?> </div>
        </div>
        <div class="errorMsg"> <?php echo $loginError; ?> </div>
        <button type="submit"> Login </button>
      </form>
      <div class="link">
      <a href="registration.php"> Create Account </a>
      </div>
    </div>
  </body>
</html>