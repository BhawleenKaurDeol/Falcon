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
    <!-- <script src="javascript/fetch.js" defer></script> -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/Signup.css">
    <link rel="icon" type="image/png" href="images/falcon-icon.png">
    <script src="javascript/profile.js" defer></script>
    
</head>
<body class="falcon-body">
    <?php 
    include "header.php";
    ?>
    <main id="main-content">
        <form id="profileForm" action="" method="post">
            <div class="profile_image"><a href="image.php"><img src="images/placeholder-face.jpg" alt="" id="profile_picture"></a></div>
            <label for="student_id"><p>Student ID</p><input type="text" name="student_id" id="student_id"></label>
    
            <label for="given_name"><p>Given Name</p><input type="text" name="given_name" id="given_name"></label>
            <label for="last_name"><p>Last Name</p><input type="text" name="last_name" id="last_name"></label>

            <label for="emailid"><p>Email</p><input type="email" name="emailid" id="emailid"></label>
            <label for="gender" ><p>Gender</p><input type="text" name="gender" id="gender" ></label>
            <label for="phone"><p>Phone</p><input type="text" name="phone" id="phone"></label><br>
            <input type="hidden" name="action" value="1">
            <input type="hidden" name="id_user" value="<?=$_SESSION['ID_USER']?>">
            <button type="submit">Save</button>

        </form>
        
    </main>

<?php
include "footer.php";
?>
<script>
   
async function logData() {
    const response = await fetch("https://inteligencia.ec/falcon/api.php?id=" + logged_user_id + "&t=users-Id&token=XXX");
    const data = await response.json();
    console.log(data);
    document.querySelector('#profile_picture').src = data[0].picture;
    document.querySelector('input[name="student_id"]').value = data[0].student_id;
    document.querySelector('input[name="emailid"]').value = data[0].email;
    document.querySelector('input[name="given_name"]').value = data[0].given_name;
    document.querySelector('input[name="last_name"]').value = data[0].last_name;
    document.querySelector('input[name="gender"]').value = data[0].gender;
    document.querySelector('input[name="phone"]').value = data[0].phone_number;
}
logData();

</script>
</body>
</html>