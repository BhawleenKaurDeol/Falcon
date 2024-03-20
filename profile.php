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
    <script src="javascript/profile.js" defer></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/Signup.css">
    <link rel="stylesheet" href="css/styles2.css">
    <link rel="icon" type="image/png" href="images/falcon-icon.png">
    
</head>
<body class="falcon-body">
    <?php 
    include "header.php";
    ?>
    <main id="main-content">
        <form id="profileForm" action="" method="POST">
            <div class="profile_image"><a href="image.php"><img src="images/placeholder-face.jpg" alt="" id="profile_picture"></a></div>
            <label for="student_id"><p>Student ID</p><input type="text" name="student_id" id="student_id"></label>
    
            <label for="given_name"><p>Given Name</p><input type="text" name="given_name" id="given_name"></label>
            <label for="last_name"><p>Last Name</p><input type="text" name="last_name" id="last_name"></label>

            <label for="email"><p>Email</p><input type="email" name="email" id="email"></label>
            <label for="gender" ><p>Gender</p><input type="text" name="gender" id="gender" ></label>
            <label for="phone_number"><p>Phone</p><input type="text" name="phone_number" id="phone_number"></label>
            <label for="date_expire"><p>Expiry date</p><input type="date" name="date_expire" id="date_expire"></label>
            <input type="hidden" name="action" value="1">
            <button type="submit">Save</button>
            <p>Hi</p>
        </form>
        
    </main>

<?php
include "footer.php";
?>

</body>
</html>