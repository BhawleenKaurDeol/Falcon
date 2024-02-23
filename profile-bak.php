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
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/png" href="images/falcon-icon.png">
    
</head>
<body class="falcon-body">
    <?php 
    include "header.php";
    ?>
    <main id="main_content">
        <nav class="top-navbar mobile-navbar">
            <ul>
                <li><a href="index.php"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i><span class="fa-sr-only">Back button</span></a></li>
                <li><p>Profile</p></li>
                <li><a href="#"><i class="fa-solid fa-ellipsis" aria-hidden="true"></i><span class="fa-sr-only">options</span></a></li>
            </ul>
        </nav>

        <nav class="top-navbar desktop-navbar">
            <ul>
                <li><a href="index.php"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i><span class="fa-sr-only">Back button</span></a></li>
                <li><p>Profile</p></li>
                <li><a href="#"><i class="fa-solid fa-ellipsis" aria-hidden="true"></i><span class="fa-sr-only">options</span></a></li>
            </ul>
        </nav>

        <section class="main-content">
            <section class="user-card">
            <p><i class="fa-solid fa-user"></i><span class="fa-sr-only">My Profile</span></p>
            <p>My Profile</p>
            </section>

            <section class="Id-card">
            <p><i class="fa-solid fa-id-card"></i><span class="fa-sr-only">Mu Id</span></p>
            <p>My Id</p>
            </section>
        </section>

        
    </main>

    <?php
include "footer.php";
?>
</body>
</html>