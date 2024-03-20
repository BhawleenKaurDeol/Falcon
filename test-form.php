<?php
ini_set('max_execution_time', '0');
header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
$force_login=false;
include "includes/application_top.php";
include "vendors/phpbarcode/php-barcode.php";
$_SESSION['ID_USER']=5;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>simple update - picture</title>
</head>
<body>
    <form action="api.php?id=1&t=schedule-userId&token=XXX" method="post" id="form_picture" style="display:flex; flex-flow:column nowrap; gap:1rem;">
        <input type="hidden" name="action" value="0">
       <label for="id_user"> id_user<input type="number" name="id_user" id="id_user" value="<?=$_SESSION['ID_USER']=5;?>"></label>
       <label for="id_course"> id_course<input type="number" name="id_course" id="id_course"></label>
       <label for="day_schedule"> day_schedule<input type="text" name="day_schedule" id="day_schedule"></label>
       <label for="start_hour_schedule"> start_hour_schedule<input type="time" name="start_hour_schedule" id="start_hour_schedule"></label>
       <label for="end_hour_schedule">end_hour_schedule <input type="time" name="end_hour_schedule" id="end_hour_schedule"></label>
       <label for="term_schedule">term_schedule <input type="text" name="term_schedule" id="term_schedule"></label>
       <label for="id_room">id_room <input type="number" name="id_room" id="id_room"></label>

<!-- id_user         -->


        <button type="submit" class="btn-login">Save <i class="fa-solid fa-arrow-right fa-lg"></i></button>
    </form>
    
    <script>
       
<?php 

echo ' let logged_user_id='.$_SESSION['ID_USER'].';';
?>

    const form = document.getElementById('form_picture');
    
    form.addEventListener('submit', async event => {
    event.preventDefault();
    
    const data = new FormData(form);
    
    console.log(Array.from(data));
    
    try {
      const res = await fetch(
        "api.php?id=" + logged_user_id + "&t=schedule-userId&token=XXX",
        {
          method: 'POST',
          body: data,
        },
      );
    
      const resData = await res.json();
    
      console.log(resData);
    
      if(resData.result=='true'){
            // window.location.replace("profile.php");
            console.log('Success!!!');
         }else{
          console.log('There was an error!!!');
       //      alert('There was an error');
         }
    } catch (err) {
      console.log(err.message);
    }
    });
        </script>
</body>
</html>