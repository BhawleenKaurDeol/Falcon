<?php
ini_set('max_execution_time', '0');
header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";
$page_title='Home';
?>
<?php
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
    <title>Falcon APP - HOME</title>
<?php 
include "headers_scripts.php";
?>
    <link rel="stylesheet" href="css/student_id.css">
    
</head>
<body class="falcon-body">
    <?php 
    include "header.php";
    ?>
    <main id="main_content">
    <div class="index_container">
    <form action="" class="search_form">
       <select class="" name="search_room" id="search_room" >
            <option></option>
            <?php
             $query_building = tep_db_query("SELECT * from building WHERE id_campus='1'");
                while ($building = tep_db_fetch_array($query_building)) {
                    $id_building = $building['id_building'];
                    $name_building = $building['name_building'];
           //echo ' <optgroup label="$name_building">';
           ?>
        <?php 
         $query_floor = tep_db_query("SELECT * from floor WHERE id_building='$id_building'");
            while ($floor = tep_db_fetch_array($query_floor)) {
                $id_floor = $floor['id_floor'];
                $name_floor = $floor['name_floor'];
        ?>
        <optgroup label="&nbsp;&nbsp;<?=$name_building?> - <?=$name_floor?>">
    
        <?php
         $query_room = tep_db_query("SELECT * from room WHERE id_floor='$id_floor'");
            while ($room = tep_db_fetch_array($query_room)) {
                $id_room = $room['id_room'];
                $code_room = $room['code_room'];
                $name_room = $room['name_room'];
        ?>
        <option value="<?=$id_room?>"><?=$name_room?></option>
          <?php 
          }?>
    
    </optgroup>
          <?php              
          }// end of levels
          ?>
        
       
              <?php
            echo ' </optgroup>';  
            } // end of buildings             
              ?>     
</select>
    </form>


   
    <h1><?=get_salutation()?> <?=$given_name?></h1>
    <div class="img_profile">
    <a href="profile.php"><img src="<?=get_user_picture($_SESSION['ID_USER'])?>" alt=""></a>
    <?php if(get_user_picture($_SESSION['ID_USER'])=='images/placeholder-face.jpg'){ ?>
    <div class="txt_profile">Please finish setting up your profile, <a href="profile.php">here</a></div>
    <?php } ?>
    </div>

    <h2>Relevant Tools</h2>
    <ul class="menu-index-tools">
        <li><a href="https://langara.ca/" target="_blank"><div class="img-border"><img src="images/langara-icon.svg" alt="Langara College"></div> Langara's Site</a></li>
        <li><a href="https://langara.ca/programs-and-courses/courses/WMDD/index.html" target="_blank"><div class="img-border"><img src="images/wmdd.svg" alt="WMDD site"></div> WMDD site</a></li>
        <li><a href="https://d2l.langara.bc.ca/d2l/login" target="_blank"> <div class="img-border"><img src="images/brightspace.svg" alt="Brightspace - D2L"></div> Brightspace</a></li>
        <li><a href="https://www.microsoft365.com/apps/?from=PortalHome" target="_blank"><div class="img-border"><img src="images/office.svg" alt="Microsoft Office 365 Tools"></div> Office 365 Tools</a></li>
        <li><a href="https://swing.langara.bc.ca/prod/twbkwbis.P_WWWLogin" target="_blank"><div class="img-border"><img src="images/students.svg" alt="Student Information System"></div> Student's Portal</a></li>
        <li><a href="https://langara.ca/campus-facilities/cafeteria/index.html" target="_blank"> <div class="img-border"><img src="images/cafeteria.svg" alt="Cafeteria - Services"></div> Cafeteria</a></li>
        <li><a href="https://langara.ca/library/index.html" target="_blank"> <div class="img-border"><img src="images/library.svg" alt="Library"></div>Library</a></li>
        <li><a href="https://langara.libcal.com/reserve/groupstudy" target="_blank"> <div class="img-border"><img src="images/study-room.svg" alt="Study Rooms"></div> Study Rooms</a></li>
    </ul>
    <h2>Saved Locations</h2>
    <ul class="room-preferences">
      <?php
      
        $query="select * from preferences where id_user='$id_user_session'";
        //echo 'session='.$query;
        $tep_query=tep_db_query($query); 
       

	while ($preferences = tep_db_fetch_array($tep_query)) {
    $id_room= $preferences['id_room'];
	   ?>
        <li class="room-border">
        <h3 style="text-align:center;"><?=get_field_room($id_room,'name_room')?></h3>
            <div class="prefences-content">
             
                  
                      <ul>
                  <li><strong>Code: </strong>
                  <?=get_field_room($id_room,'code_room')?>
                  </li>
                  <li><strong>Room Type: </strong><?=get_field_room($id_room,'type_room')?></li>
                  <li><strong>Floor: </strong><?=get_field_floor(get_field_room($id_room,'id_floor'),'name_floor')?></li>
                  
                      </ul>
                
                    
            </div>
            <div style="text-align:center"><strong>Building: </strong><img src="images/<?=get_field_building(get_field_floor(get_field_room($id_room,'id_floor'),'id_building'),'code_building');?>.svg" alt="A Building"></div>
            <div class="buttons-preferences"><a href="room.php?id=<?=$id_room?>" class="btn  btn-success"><i class="fa-solid fa-chalkboard"></i> Open Room</a> <a href="room.php?id=<?=$id_room?>" class="btn btn-success"><i class="fa-solid fa-map-pin"></i> Show on map</a></div><button type="button" onclick="confirm_del_preference(logged_user_id,'<?=$id_room?>','<?=get_field_room($id_room,'code_room')?>')" class="<?=check_preference($_SESSION['ID_USER'], $id_room)?'heart-btn-selected':'heart-btn'?>"><i class="fa-solid fa-heart"></i></button>
            </li>
            <?php 
            }
            ?>
      

    
    </ul>
</div>

    </main>
    <script>

     
    </script>
<?php
include "footer.php";
?>

</body>
</html>