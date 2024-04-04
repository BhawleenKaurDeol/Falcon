<?php
ini_set("max_execution_time", "0");
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";
$page_title = "Schedule";
?>
 <?php
      $min_hour=get_min_hour_schedule($id_user_session);
     $max_hour=get_max_hour_schedule($id_user_session);
   //  echo 'start='.$min_hour.'<br>';
   //  echo 'end='.$max_hour.'<br>';

    $schedule_hours=get_time_slots($min_hour, $max_hour, 30);
    
     function get_time_slots($start_hour, $end_hour, $span=30){
      $new_start=substr($start_hour,0,2).':00';
      $start = strtotime($new_start);
      $end= strtotime($end_hour);
    //  echo 'hora:'.$start.'<br>';
$diff_minutes = round(abs($start - $end) / 60,2);
$steps= ceil($diff_minutes/$span);
if($steps>0){
  $steps++;
}
$mins = range(0,($span*60)*$steps,($span*60)); //Measured in seconds.

$result['steps']=$steps;
$result['slots']=array();
if($steps>0){
      foreach($mins AS $min) {
       $time = date('H:i',$start+$min);
      // if(strtotime($end_hour)>=strtotime($time)){
       $result['slots'][]=$time;
      // }
      }
    }
      return $result;
     }
      function get_min_hour_schedule($id){
       $result='';
         $query_hour = tep_db_query("SELECT start_hour_schedule as result FROM `schedule` WHERE id_user = '$id' ORDER BY start_hour_schedule ASC LIMIT 1");
while ($result_arr = tep_db_fetch_array($query_hour)) {
   $result = $result_arr['result'];
}
        return substr($result,0,5);  
      }
      function get_max_hour_schedule($id){
       $result='';
         $query_hour = tep_db_query("SELECT end_hour_schedule as result FROM `schedule` WHERE id_user = '$id' ORDER BY end_hour_schedule DESC LIMIT 1");
while ($result_arr = tep_db_fetch_array($query_hour)) {
   $result = $result_arr['result'];
}
        return substr($result,0,5);  
      }
      ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Falcon APP - PROFILE</title>
    <style>
      :root{
        --schedule-rows-number: <?=$schedule_hours['steps']?>;
      }
         
    </style>
    <link rel="stylesheet" href="vendors/schedule/css/style.css">
    <?php
  include "headers_scripts.php";
  ?>
  <script>document.getElementsByTagName("html")[0].className += " js";</script>
 
   <link rel="stylesheet" href="css/schedule.css">
    <!--  <script src="javascript/schedule.js" defer></script> -->
    
</head>
<body class="falcon-body ">
    <?php include "header.php"; ?>
   
    <main id="main_content" class="schedule">


  <div class="cd-schedule cd-schedule--loading margin-top-lg js-cd-schedule">
    <div class="cd-schedule__timeline">
   
      <ul>
        <?php 
        foreach($schedule_hours['slots'] as $key => $value){?>
        <li><span><?=$value?></span></li>
<?php } ?>

      </ul>
    </div> <!-- .cd-schedule__timeline -->
  
    <div class="cd-schedule__events">
      <ul>
      <?php
      $i=1;
$days_array=['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
foreach($days_array as $key => $day_schedule_0){
     ?>
        <li class="cd-schedule__group">
          <div class="cd-schedule__top-info"><span><?=$day_schedule_0?></span></div>
  
          <ul>
<?php

 $query_schedule = tep_db_query("SELECT
 `schedule`.id_schedule, 
 `schedule`.day_schedule, 
 `schedule`.start_hour_schedule, 
 `schedule`.end_hour_schedule, 
 course.name_course, 
 course.instructor_course, 
 course.program_course, 
 room.code_room, 
 room.name_room
FROM
 `schedule`
 INNER JOIN
 course
 ON 
   `schedule`.id_course = course.id_course
 INNER JOIN
 room
 ON 
   `schedule`.id_room = room.id_room
WHERE
 `schedule`.id_user = '".$_SESSION['ID_USER']."' AND `schedule`.day_schedule = '".$day_schedule_0."'");
 while ($schedule = tep_db_fetch_array($query_schedule)) {
     $id_schedule = $schedule['id_schedule'];
     $name_course = $schedule['name_course'];
     $instructor_course = $schedule['instructor_course'];
     $program_course = $schedule['program_course'];
     $day_schedule = $schedule['day_schedule'];
     $start_hour_schedule = $schedule['start_hour_schedule'];
     $end_hour_schedule = $schedule['end_hour_schedule'];
     $code_room = $schedule['code_room'];
     $name_room = $schedule['name_room'];
?>
  
            <li class="cd-schedule__event">
              <a data-start="<?=substr($start_hour_schedule,0,5)?>" data-end="<?=substr($end_hour_schedule,0,5)?>" data-content="<?=$id_schedule?>" data-event="event-<?=$i?>" href="#0">
                <em class="cd-schedule__name"><?=$name_course?></em> 
                <span class="cd-schedule__instructor"><i class="fa-regular fa-circle-dot fa-2xs"></i> <?=$instructor_course?></span>
                <span class="cd-schedule__room"><i class="fa-regular fa-circle-dot fa-2xs"></i> <?=$name_room?></span>
              </a>
            </li>
  
<?php 
$i++;
if($i>3){ //max colors
  $i=1;
} 
}
?>
          </ul>
        </li>
  <?php
 }
  ?>
      </ul>
    </div>
  
    <div class="cd-schedule-modal">
      <header class="cd-schedule-modal__header">
        <div class="cd-schedule-modal__content">
          <span class="cd-schedule-modal__date"></span>
          <h3 class="cd-schedule-modal__name"></h3>
        </div>
  
        <div class="cd-schedule-modal__header-bg"></div>
      </header>
  
      <div class="cd-schedule-modal__body">
        <div class="cd-schedule-modal__event-info"></div>
        <div class="cd-schedule-modal__body-bg"></div>
      </div>
  
      <a href="#0" class="cd-schedule-modal__close text-replace">Close</a>
    </div>
  
    <div class="cd-schedule__cover-layer"></div>
  </div> <!-- .cd-schedule -->

<button class="btn btn-success" id="myBtn" type="button" style="margin-left:auto; margin-right:auto;"><i class="fa-regular fa-calendar-plus"></i> Add Course</button>
    </main>
<!-- Trigger/Open The Modal -->


<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close"><i class="fa-solid fa-xmark"></i></span>
    <div id="modal_content_div"></div>
  </div>

</div>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
$('.cd-schedule__group ul').on('click', function(e) {
  if (e.target !== this)
    return;
  
  modal.style.display = "block";
  load_page_dom('schedule_details.php?action=add','#modal_content_div');
  
});

btn.onclick = function() {
  modal.style.display = "block";
  load_page_dom('schedule_details.php?action=add','#modal_content_div')
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
<?php include "footer.php"; ?>
<script src="vendors/schedule/js/util.js"></script> <!-- util functions included in the CodyHouse framework -->
  <script src="vendors/schedule/js/main.js"></script>
  <script>
    
function confirm_del_schedule(id_schedule){
    Swal.fire({
title: "Are you sure you want to proceed?",
text: "You won't be able to undo this, unless you add the course again.",
icon: "warning",
showCancelButton: true,
confirmButtonColor: "#3085d6",
cancelButtonColor: "#d33",
confirmButtonText: "Yes, remove it!"
}).then((result) => {
if (result.isConfirmed) {
    load_page_dom('schedule_details.php?id='+id_schedule+'&action=delete','_top')
}
});
    }
  </script>
</body>
</html>