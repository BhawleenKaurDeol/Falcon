<?php
ini_set('max_execution_time', '0');
header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
$force_login = false;
include "includes/application_top.php";

$student_id = '';
$password = '';
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
}
if (isset($_GET['password'])) {
    $password = $_GET['password'];
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

    <script src="javascript/createAccount.js" defer></script>
    <script src="vendors/sweetalert/sweetalert-v2.11.js"></script>

    <link rel="stylesheet" href="css/styles.css">

    <link rel="stylesheet" href="css/Signup.css">
</head>

<body class="falcon-body">

    <main id="main-content">
        <div class="login-content">
            <div class="logo-falcon" style="display: flex; gap: 1rem;">
                <img src="images/falcon-isotype.svg" alt="Falcon APP - Logo" class="logo-signup">
                <h1 class="signup_h1">Falcon</h1>
            </div>
            <h2>Sign Up - Create an account</h2>
            <form action="" method="post" id="SignUpForm">

                <div class="input-container">
                    <input type="text" name="student_id" id="student_id" value="<?= $student_id ?>" required min="9" max="9" onkeydown="limit(this);" onkeyup="limit(this);">

                    <label for="student_id">
                        Student ID
                    </label>
                </div>

                <div id="requirement_student_id" class="password-requirements">
                    <p class="requirement" id="student_length">Min. 9 characters</p>
                    <p class="requirement" id="student_exists">Available for registration</p>
                </div>

                <div class="input-container">
                    <input type="text" name="given_name" id="given_name" required>
                    <label for="given_name">Given Name</label>
                </div>

                <div class="input-container">
                    <input type="text" name="last_name" id="last_name" required>
                    <label for="last_name">Last Name</label>
                </div>
                <div class="input-container">
                    <input type="email" name="email" id="email" aria-describedby="requirements" required>
                    <label for="email">Email
                    </label>
                </div>

                <div class="input-container">
                    <input type="password" id="password" aria-describedby="requirements" required name="password" />
                    <label for="password">Password</label>
                    <button class="show-password" id="show-password" type="button" role="switch" aria-label="Show password" aria-checked="false"><i class="fa-solid fa-eye fa-2xl"></i></button>
                </div>

                <div id="requirements" class="password-requirements">
                    <p class="requirement" id="length">Min. 8 characters</p>
                    <p class="requirement" id="lowercase">Include lowercase letter</p>
                    <p class="requirement" id="uppercase">Include uppercase letter</p>
                    <p class="requirement" id="number">Include number</p>
                    <p class="requirement" id="characters">Include a special character: #.-?!@$%^&*</p>
                </div>

                <div class="input-container">
                    <input type="password" id="confirm-password" required />
                    <label for="confirm-password">Confirm password</label>
                </div>

                <div class="password-requirements">
                    <p class="requirement hidden error" id="match">Passwords must match</p>
                </div>

                <input type="hidden" name="action" value="0">
                <input type="hidden" name="date_creation" value="<?= date('Y-m-d h:i:s') ?>">
                <input type="hidden" name="student_id_exists" id="student_id_exists" value="true">

                <button type="submit" id="CreateBtn" disabled>Create Your Account <i class="fa-regular fa-user"></i></button>
            </form>
            <div class="signup">
                <p>Already have an account?</p>
                <button class="btn-signup" id="btn_login" type="button"><i class="fa-solid fa-arrow-left fa-lg"></i> Back to Login</button>
            </div>
        </div>
    </main>

</body>

</html>