<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set("max_execution_time", "0");
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";

$page_title = "Schedule";

$action=$_GET['action']??'';
$id=$_GET['id']??'';

if($action=='save'){
    $program=$_GET['program']??'';
    $course=$_GET['course']??'';
    $term=$_GET['term']??'';
    $day=$_GET['day']??'';
    $start_time=$_GET['start_time']??'';
    $end_time=$_GET['end_time']??'';
    $room=$_GET['room']??'';

    if(!empty($id)){
        tep_db_query("UPDATE `schedule` SET `id_user` = $id_user_session, `id_course` = '$course', `day_schedule` = '$day', `start_hour_schedule` = '$start_time', `end_hour_schedule` = '$end_time', `term_schedule` = '$term', `id_room` = '$room' WHERE `id_schedule` = '$id'");
        add_room_preferences($id_user_session,$room);
    }else{

        tep_db_query("INSERT INTO `schedule`(`id_user`, `id_course`, `day_schedule`, `start_hour_schedule`, `end_hour_schedule`, `term_schedule`, `id_room`) VALUES ('$id_user_session', '$course', '$day', '$start_time', '$end_time', '$term', '$room')");
        add_room_preferences($id_user_session,$room);
    }
    header('Location: schedule.php');
}elseif($action=='delete'){
    if(!empty($id)){
    tep_db_query("DELETE FROM `schedule` WHERE `id_schedule` = '$id'");
    del_room_preferences($id_user_session,$room);
    }
    header('Location: schedule.php');
}

function add_room_preferences($id_user,$id_room){
    tep_db_query("DELETE FROM `preferences` WHERE `id_user` = '$id_user' AND id_room='$id_room'");
    tep_db_query("INSERT INTO `preferences`(`id_user`, `id_room`) VALUES ('$id_user', '$id_room')");
}
function del_room_preferences($id_user,$id_room){
    tep_db_query("DELETE FROM `preferences` WHERE `id_user` = '$id_user' AND id_room='$id_room'");
    tep_db_query("INSERT INTO `preferences`(`id_user`, `id_room`) VALUES ('$id_user', '$id_room')");
}

$query_schedule = tep_db_query("SELECT
 `schedule`.id_schedule, 
 `schedule`.day_schedule, 
 `schedule`.start_hour_schedule, 
 `schedule`.end_hour_schedule, 
 `schedule`.term_schedule,
 course.name_course, 
 course.instructor_course, 
 course.program_course, 
 room.id_room, 
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
 `schedule`.id_schedule = '" . $id . "'");
  $id_schedule = '';
  $name_course = '';
  $instructor_course = '';
  $program_course = '';
  $day_schedule = '';
  $start_hour_schedule = '';
  $end_hour_schedule = '';
  $term_schedule = '';
  $code_room = '';
  $name_room = '';
  $id_room = '';
while ($schedule = tep_db_fetch_array($query_schedule)) {
    $id_schedule = $schedule['id_schedule'];
    $name_course = $schedule['name_course'];
    $instructor_course = $schedule['instructor_course'];
    $program_course = $schedule['program_course'];
    $day_schedule = $schedule['day_schedule'];
    $start_hour_schedule = $schedule['start_hour_schedule'];
    $end_hour_schedule = $schedule['end_hour_schedule'];
    $term_schedule = $schedule['term_schedule'];
    $code_room = $schedule['code_room'];
    $name_room = $schedule['name_room'];
    $id_room = $schedule['id_room'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Details</title>
    <?php
  include "headers_scripts.php";
  ?>
</head>

<body>
    <div class="schedule_details" style="<?=$action=='add'?'padding: 0em;':'padding: 1.25em;'?>">
        <h1><?= $action=='edit'?'Edit Schedule':$name_course ?><?= $action=='add'?'Add a new record':$name_course ?></h1>
        <form class="room" method="get" action="schedule_details.php" target="_top" onsubmit="return validate_schedule_details(this);">
            <table>
            <tr>
                    <th><label for="program">Program</label></th>
                    <td><?php if($action=='edit'||$action=='add'){ ?><select name="program" id="program">
                        <option value="Web and Mobile App Design and Development">Web and Mobile App Design and Development</option>
                    </select><?php }else{ ?><span><?= $program_course ?></span><?php } ?></td>
                </tr>

                <?php if($action=='edit'||$action=='add'){ ?>
            <tr>
                    <th><label for="course">Course</label></th>
                    <td><input type="hidden" value="save" name="action">
                    <input type="hidden" value="<?=$id?>" name="id">


                    <select name="course" id="course">
                       
                        
<?php
$query_course = tep_db_query("SELECT * FROM `course` WHERE status_course = 'active' ORDER BY name_course ");
while ($arr_course = tep_db_fetch_array($query_course)) {
   $_id_schedule = $arr_course['id_course'];
   $_name_course = $arr_course['name_course'];
?>
                        <option value="<?=$_id_schedule ?>" <?=($_name_course==$name_course?'selected':'')?>><?= $_name_course ?></option>
                    <?php } ?>
                    </select></td>
                </tr>
<?php }else{
?>
<tr>
                    <th><label for="instructor">Instructor</label></th>
                    <td><span><?= $instructor_course ?></span></td>
                </tr>
<?php
} ?>
                
             
               
                <tr>
                    <th><label for="term">Term</label></th>
                    <td><?php if($action=='edit'||$action=='add'){ ?><select name="term" id="term">
                        <option value="Spring 2024">Spring 2024</option>
                    </select><?php }else{ ?><span><?= $term_schedule ?></span><?php } ?></td>
                </tr>
                <tr>
                    <th><label for="day">Day</label></th>
                    <td><?php if($action=='edit'||$action=='add'){  $_days=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];?>
                        
                        <select name="day" id="day">
                            <?php 
                            foreach($_days as $key => $value){ ?>
                        <option value="<?=$value?>" <?=($value==$day_schedule)?'selected':''?>><?=$value?></option>
                        <?php } ?>
                    </select><?php }else{ ?><span><?= $day_schedule ?></span><?php } ?></td>
                </tr>
                <tr>
                    <th><label for="start_time">Start Time</label></th>
                    <td><?php if($action=='edit'||$action=='add'){ ?><input type="time" name="start_time" id="start_time" value="<?= substr($start_hour_schedule, 0, 5) ?>"  min="08:00" max="19:00" required><?php }else{ ?><span><?= substr($start_hour_schedule, 0, 5) ?></span><?php } ?></td>
                </tr>
                <tr>
                    <th><label for="end_time">End Time</label></th>
                    <td><?php if($action=='edit'||$action=='add'){ ?><input type="time" name="end_time" id="end_time" value="<?= substr($end_hour_schedule, 0, 5) ?>"  min="08:00" max="19:00" required><?php }else{ ?><span><?= substr($end_hour_schedule, 0, 5) ?></span><?php } ?></td>
                </tr>
                <tr>
                    <th><label for="room">Room</label></th>
                    <td><?php if($action=='edit'||$action=='add'){ ?><select name="room" id="room">
                        <?php $query_room = tep_db_query("SELECT * FROM `room` WHERE status_room = 'active' ORDER BY name_room ");
while ($arr_room = tep_db_fetch_array($query_room)) {
   $_id_room = $arr_room['id_room'];
   $_name_room = $arr_room['name_room'];
   ?>
                        <option value="<?= $_id_room?>" <?=$id_room==$_id_room?'selected':''?>><?= $_name_room?></option>
                        <?php } ?>
                    </select>
                        <?php }else{ ?><span><?= $name_room ?></span>
                        <div class="buttons-schedule"><a href="room.php?id=<?= $id_room ?>" class="btn  btn-success" style="width:30px"><i class="fa-solid fa-person-chalkboard"></i></a> <a href="map-list.php?<?= get_link_room_highlighted($id_room) ?>" class="btn btn-success" style="width:30px"><i class="fa-solid fa-map-pin"></i></a><?php } ?></div>
                    </td>
                </tr>
                <?php if($action!='edit'&&$action!='add'){ ?>
                <tr>
                    <th>Building</th>
                    <td><span><?= get_field_building(get_field_floor(get_field_room($id_room, 'id_floor'), 'id_building'), 'name_building'); ?></span>
                        <div class="buttons-schedule"><a href="map-list.php?active_building=<?= get_field_building(get_field_floor(get_field_room($id_room, 'id_floor'), 'id_building'), 'code_building') ?>" class="btn btn-success" style="width:30px"><i class="fa-solid fa-map-pin"></i></a></div>
                    </td>
                </tr>
                <tr>
                    <th>Level</th>
                    <td><span><?= get_field_floor(get_field_room($id_room, 'id_floor'), 'name_floor'); ?></span> </td>
                </tr>
                <?php } ?>
            </table>
            <?php if($action=='edit'||$action=='add'){ ?>
<div class="buttons-preferences" style="margin-top: 1rem;"><button class="btn btn-success" type="submits"><i class="fa-regular fa-calendar-check"></i> Save record</button></div>
                <?php }else{ ?>
            <div class="buttons-preferences" style="margin-top: 1rem;"><a href="#" onclick="load_page_dom('schedule_details.php?id=<?= $id_schedule ?>&action=edit','.cd-schedule-modal__event-info')" class="btn btn-success"><i class="fa-regular fa-calendar-plus"></i> Edit record</a><a href="#" onclick="confirm_del_schedule('<?= $id_schedule ?>');" class="btn btn-grey"><i class="fa-regular fa-calendar-xmark"></i> Delete record</a></div>
<?php } ?>
            
        </form>
    </div>
<script>
function validate_schedule_details(form){
    console.log(form.start_time.value);
    var from_time= form.start_time.value;
     var to_time = form.end_time.value;

var from = Date.parse('01/01/2011 '+ from_time);
var to = Date.parse('01/01/2011 '+ to_time);

if (from > to){
    error_message("Start Time can not be greater than End Time");
    return false;
} else{
    return true;
}
    
}


</script>
</body>

</html>