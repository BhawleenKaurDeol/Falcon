<?php
ini_set('max_execution_time', '0');
header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";



$page_title='Profile';
if (isset($_SESSION['ID_USER'])) {

    $query = "SELECT * from users WHERE id_user='" . $_SESSION['ID_USER'] . "'";
    $student_query = tep_db_query($query);
    $total = mysqli_num_rows($student_query);
  
    if ($total > 0) {
  
      while ($student = tep_db_fetch_array($student_query)) {
  
        $type_user = $student['type_user'];
        $student_id = $student['student_id'];
        $staff_id = $student['staff_id'];
        $given_name = $student['given_name'];
        $last_name = $student['last_name'];
        $picture = $student['picture'];
        $email = $student['email'];
        $gender = $student['gender'];
        $phone_number = $student['phone_number'];
        $password = $student['password'];
  
        $date_c = date_create($student['date_creation']);
        $date_creation = date_format($date_c, 'Y-m-d');
        $date_e = date_create($student['date_expire']);
        $date_expire = date_format($date_e, 'Y-m-d');
      }
    }
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Falcon APP - PROFILE</title>

    <?php 
include "headers_scripts.php";
?>
    <script src="javascript/profile2.js" defer></script>  
    <link rel="stylesheet" href="css/profile2.css">
</head>
<body class="falcon-body">
    <?php 
    include "header.php";
    ?>

    <main id="main-content">
        <div class="login-content">

            <form action="" method="post" id="SignUpForm">
                
            <div class="img_profile">
    <a href="image.php"><img src="<?=get_user_picture($_SESSION['ID_USER'])?>" alt="" id="profile_picture">
    <button class="edit-btn" type="button"><i class="fa-solid fa-pen"></i></button></a>

    
    </div>
            <div class="input-container">
                <input type="text" name="student_id" id="student_id"  value="<?=$student_id?>" required min="9" max="9" onkeydown="limit(this);" onkeyup="limit(this);" class="<?=!empty($student_id)?'is-valid':''?>" disabled readonly>
               
                    <label for="student_id">
                        Student ID
                    </label>
                </div>
                <div id="requirement_student_id" class="password-requirements">
      <p class="requirement" id="student_length">Min. 9 characters</p>
      <p class="requirement" id="student_exists">Available for registration</p>
</div>
                <div class="input-container">
                    <input type="text" name="given_name" id="given_name"  required value="<?=$given_name?>" class="<?=!empty($given_name)?'is-valid':''?>">
                    <label for="given_name">Given Name</label>
            </div>

            <div class="input-container">
                <input type="text" name="last_name" id="last_name" required value="<?=$last_name?>" class="<?=!empty($last_name)?'is-valid':''?>">
                <label for="last_name">Last Name</label>
</div>
                <div class="input-container">
                    <input type="email" name="email" id="email" aria-describedby="requirements" required value="<?=$email?>" class="<?=!empty($email)?'is-valid':''?>">
                    <label for="email">Email
                </label>
            </div>
            <div class="select-container">
                <select name="gender" id="gender" class="<?=!empty($gender)?'is-valid':''?>">
                    <option value=""></option>
                    <?php
                    $gender_array=array('Female','Male','Non-binary','Prefer not to say');
                    foreach($gender_array as $key => $value){
                        
                        echo '<option value="'.$value.'" '.($value==$gender?'selected':'').'>'.$value.'</option>';
                    }
                    ?>
                </select>
                    <label for="gender">Gender</label>
            </div>
                <div class="input-container">
                    <input type="tel" name="phone_number" id="phone_number" aria-describedby="requirements" required value="<?=$phone_number?>" class="<?=!empty($phone_number)?'is-valid':''?>">
                    <label for="phone_number">Phone
                </label>
            </div>
                <div class="input-container">
                    <input type="date" name="date_expire" id="date_expire" aria-describedby="requirements" required value="<?=$date_expire?>" class="<?=!empty($date_expire)?'is-valid':''?>">
                    <label for="date_expire">Expiry Date
                </label>
            </div>

            <div class="input-container">
      <input type="password" id="password" aria-describedby="requirements" required name="password" value="<?=$password?>" class="<?=!empty($password)?'is-valid':''?>"/>
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
      <input type="password" id="confirm-password" required value="<?=$password?>" class="<?=!empty($password)?'is-valid':''?>" />
      <label for="confirm-password">Confirm password</label>
    </div>

    <div class="password-requirements">
      <p class="requirement hidden error" id="match">Passwords must match</p>
    </div>
    
     <input type="hidden" name="action" value="1">

                <button type="submit" class="btn-login" id="CreateBtn" disabled>Save <i class="fa-regular fa-user"></i></button>
            </form>
        </div>
    </main>
<?php
include "footer.php";
?>
</body>

</html>