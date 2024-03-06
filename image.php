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
    <link rel="stylesheet" href="vendors/cropper.js/cropper.css">
    <link rel="stylesheet" href="css/images.css">
    <script defer src="vendors/cropper.js/cropper.js"></script>
    <script defer src="javascript/image.js"></script>
    <title>Image Cropper</title>
    <script src="https://kit.fontawesome.com/6155c8fec8.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="images/falcon-icon.png">

    <script src="profile.js" defer></script>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="falcon-body">
    <?php 
    include "header.php";
    ?>
    <main id="main_content">
<div class="main-container">
    <div class="camera">
        <video id="video">Video stream not available.</video>
        <button id="startbutton">Take photo</button>
    </div>
    <canvas id="canvas" style="display: none;"></canvas>
    
    <div class="img-container" style="display: none;">
        <img id="image-to-crop" src="" class="crop-target" alt="Captured image will appear here...">
    </div>
        <input type="file" id="file-input" accept="image/*">
        <button id="btn-crop">Crop</button>
    <div class="cropped-img">
        <img src="" id="output" alt="cropped image" id="img">
        <button id="submit" onclick="SetProfileImage()">Set Profile Image</button>
    </div>
</div>
</main>
<?php
include "footer.php";
?>
</body>
</html>
