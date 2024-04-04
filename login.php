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

    <link rel="manifest" href="./app.webmanifest">
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
                <button class="btn-signup" id="btn_signup" type="button">Create an account <i class="fa-regular fa-user"></i></button>
            </div>
        </div>
    </main>
    <script>
      ;(async () => {
            // does the browser support service workers?
            if ('serviceWorker' in navigator) {
                // then register our service worker
              try {
                const reg = await  navigator.serviceWorker.register('./sw.js');
                // display a success message
                console.log(`Service Worker is Registered:`, reg);
              } catch(error) {
                // display an error message
                console.log(`Service Worker Error (${error})`);
              };

              // ready is a Promise that never rejects and resolved when the service worker is active. 
              const active = await navigator.serviceWorker.ready;
              // we have an active service worker working for us
              console.log(`Service Worker is Active:`, active);
              // At this point, you can call methods that require an active service worker,
              // like registration.pushManager.subscribe() for push notification
            } else {
              // happens when the app isn't served over a TLS connection (HTTPS)
              console.warn('Service Worker not available');
            }
        })();//async IIFE
  
</script>
</body>

</html>