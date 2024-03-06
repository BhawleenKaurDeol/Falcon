<?php
ini_set('max_execution_time', '0');
header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Falcon APP - PROFILE</title>
    <script src="https://kit.fontawesome.com/6155c8fec8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/Signup.css">
    <link rel="icon" type="image/png" href="images/falcon-icon.png">
    
</head>
<body class="falcon-body">
    <?php 
    include "header.php";
    ?>
    <main id="main-content">
        <form action="">
            <div class="profile_image"><a href="image.php"><img src="images/placeholder-face.jpg" alt=""></a></div>
            <label for="student-id"><p>Student ID</p><input type="text" name="student-id"></label>
            <label for="emailid"><p>Email</p><input type="emai" name="emailid"></label>
            <label for="password-field" class="password-field"><p>Password</p><input type="password" name="password-field" ></label>
            <label for="password-field2"><p>Confirm password</p><input type="password" name="password-field2"></label><br>
            <button type="submit">Confirm</button>
        </form>
        <div class="login">
            <p>Already have an accout?</p>
            <a href="#">Log in <i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </main>

<?php
include "footer.php";
?>
</body>
</html>