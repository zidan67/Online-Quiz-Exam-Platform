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
    <script src="../Controller/JSV/login.js"></script>
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
          justify-content:center;
          align-items:center;
          min-height:100vh;
          padding:20px;
      }

      .container{
          width:100%;
          max-width:520px;
      }

      .loginBox{
          background:white;
          border-radius:18px;
          padding:40px;
          border:1px solid #e5e7eb;
          box-shadow:0 4px 20px rgba(0,0,0,0.05);
      }

      .top{
          text-align:center;
          margin-bottom:30px;
      }

      .top i{
          font-size:60px;
          color:#1456e1;
          margin-bottom:15px;
      }

      .top h1{
          font-size:42px;
          color:#111827;
          margin-bottom:10px;
      }

      .top p{
          font-size:22px;
          color:#6b7280;
      }

      .line{
          width:100%;
          height:1px;
          background:#e5e7eb;
          margin-bottom:30px;
      }

      .reg{
          margin-bottom:22px;
      }

      .reg label{
          display:block;
          margin-bottom:10px;
          font-size:18px;
          font-weight:600;
          color:#111827;
      }

      .inputBox{
          position:relative;
      }

      .inputBox i{
          position:absolute;
          left:18px;
          top:50%;
          transform:translateY(-50%);
          color:#6b7280;
          font-size:18px;
      }

      .inputBox input{
          width:100%;
          height:58px;
          border:1px solid #cfd7e6;
          border-radius:12px;
          padding-left:50px;
          padding-right:15px;
          font-size:17px;
          outline:none;
          transition:0.3s;
      }

      .inputBox input:focus{
          border-color:#1456e1;
          box-shadow:0 0 0 4px rgba(20,86,225,0.1);
      }

      .errorMsg{
          color:red;
          font-size:15px;
          margin-top:6px;
      }

      .loginError{
          color:red;
          text-align:center;
          margin-bottom:18px;
          font-size:16px;
      }

      button{
          width:100%;
          height:58px;
          border:none;
          border-radius:12px;
          background:#1456e1;
          color:white;
          font-size:20px;
          font-weight:bold;
          cursor:pointer;
          transition:0.3s;
      }

      button:hover{
          background:#0f46bc;
      }

      .link{
          text-align:center;
          margin-top:22px;
      }

      .link a{
          text-decoration:none;
          color:#1456e1;
          font-size:17px;
          font-weight:600;
      }

      .link a:hover{
          text-decoration:underline;
      }

    </style>
  </head>
  <body>
<div class="container">
  <div class="loginBox">
    <div class="top">
      <i class="fa-solid fa-user-graduate"></i>
      <h1>Welcome Back</h1>
      <p>Login to your account</p>
    </div>
    <div class="line"></div>
    <form action="../Controller/loginValidate.php" method="POST" onsubmit="return validateLogin()">
      <div class="reg">
        <label>Email Address</label>
        <div class="inputBox">
          <i class="fa-regular fa-envelope"></i>
          <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>">
        </div>
        <div class="errorMsg" id="emailError"> <?php echo $emailError; ?> </div>
      </div>
      <div class="reg">
        <label>Password</label>
        <div class="inputBox">
          <i class="fa-solid fa-lock"></i>
          <input type="password" id="password" name="password" placeholder="Enter your password">
        </div>
        <div class="errorMsg" id="passwordError"> <?php echo $passwordError; ?> </div>
      </div>
      <div class="loginError"> <?php echo $loginError; ?> </div>
      <button type="submit"> Login </button>
    </form>
    <div class="link">
      <a href="registration.php"> Create Account </a>
    </div>
  </div>
</div>
       
  </body>
</html>