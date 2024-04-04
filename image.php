<?php
ini_set('max_execution_time', '0');
header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";
$page_title="Profile > Image"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
include "headers_scripts.php";
?>

    <link rel="stylesheet" href="vendors/cropper.js/cropper.css">
    <script  src="vendors/cropper.js/cropper.js" defer></script>
    <script  src="javascript/image.js" defer></script>
    <!-- <script  src="javascript/webcam.js" defer></script> -->
    <title>Image Cropper</title>


    <link rel="stylesheet" href="css/image.css">
    <!-- <link rel="stylesheet" href="css/images.css"> -->
   


</head>
<body class="">
    <div class="falcon-body image-body">
        <?php
        include "header.php";
        ?>
        
        <!-- <div id="myModal" class="modal">
        <div class="modal-content">
        
            <p>Select an option:</p>
            <button id="cameraBtn">Camera</button>
            <label for="file-input" id="uploadBtn">Upload</label>
            <input type="file" id="file-input" accept="image/*"  />
        </div>
        </div> -->
        <main id="main_content">
        <div class="main-container">
        <div class="hide" id="image_camera">
            <div class="camera">
                <video id="video">Video stream not available.</video>
            </div>
            <div class="button">
            <button id="startbutton" >Take photo</button>
            </div>
            <canvas id="canvas" ></canvas>
        </div>
        <div class="hide" id="image_cropper">
        
            <div class="img-container" >
                <img id="image-to-crop" src="images/placeholder-640x480.webp" class="crop-target" alt="Captured image will appear here...">
            </div>
        
                <div class="crop button"><button id="btn-crop"><i class="fa-solid fa-crop"></i> Crop</button></div>
                <input type="file" id="file-input" accept="image/*" class="hide"  />
        </div>
        <div class="hide" id="image_result">
            <div class="cropped-img">
                <img src="" id="output" alt=" ">
            </div>
            <form action="" method="post" id="form_picture">
              <input type="hidden" name="action" value="1">
              <input type="hidden" id="picture" name="picture" value="">
              <div class="save-cancel">
                <button type="submit" id="save"><i class="fa-solid fa-floppy-disk"></i> Save </button>
                <button id="cancel" ><i class="fa-solid fa-xmark"></i> Cancel</button>
            </div>
              </form>
        </div>
        
        </div>
        </main>
        <?php
        include "footer.php";
        ?>
    </div>
</body>
</html>
