<?php
ini_set('max_execution_time', '0');
header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

include "includes/application_top.php";

$student_id='';
$password='';
if(isset($_GET['student_id'])){
    $student_id=$_GET['student_id'];
}
if(isset($_GET['password'])){
    $password=$_GET['password'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Falcon APP - LOGIN</title>
    <script src="https://kit.fontawesome.com/6155c8fec8.js" crossorigin="anonymous"></script>

    <link rel="icon" type="image/png" href="images/falcon-icon.png">

    <script src="javascript/login.js" defer></script>
    <script src="vendors/sweetalert/sweetalert-v2.11.js"></script>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body class="falcon-body">

    <main id="main-content">
        <div class="login-content">
            <form action="" method="post" id="form_login">
                <div class="logo-falcon">
                    <img src="images/falcon-isotype.svg" alt="Falcon APP - Logo" class="logo">
                    <h1>Falcon</h1>
                </div>
                <div class="input-group">
                    <label for="student_id">
                        Student ID
                    </label>
                    <input type="text" name="student_id" id="student_id" placeholder="Student0000" value="<?=$student_id?>" >
                </div>
                <div class="input-group">
                    <label for="password" class="password">
                        Password
                    
                    </label>
                    <input type="password" name="password_student" id="password_student" placeholder="Password" value="<?=$password?>">
                        <a href="#" class="forgot">Forgot password?</a>
                </div>
               
                <button type="submit" class="btn-login">Login <i class="fa-solid fa-arrow-right fa-lg"></i></button>
            </form>
            <div class="signup">
                <p>New to the App? Create Your Own Account</p>
                <button class="btn-signup">Create an account <i class="fa-regular fa-user"></i></button>
            </div>
        </div>
    </main>
<script>
   
    </script>

</body>

</html>