<?php
ini_set("max_execution_time", "0");
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";
$page_title = "Room - ";
if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  header('Location: map-list.php');
}
if (is_numeric($id) && !empty($id)) {
  $query = "SELECT * from room WHERE id_room='" . $id . "'";
  //echo $query;
  $room_q_query = tep_db_query($query);
  $total = mysqli_num_rows($room_q_query);

  if ($total > 0) {

    while ($room_q = tep_db_fetch_array($room_q_query)) {

      $_id_room = $id;
      $_id_floor = $room_q['id_floor'];
      $_code_room = $room_q['code_room'];
      $_name_room = $room_q['name_room'];
      $_status_room = $room_q['status_room'];
      $_image3d_room = $room_q['image3d_room'];
      $_type_room = $room_q['type_room'];
    }
    $page_title .= $_name_room;
  } else {
    header('Location: map-list.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Falcon APP - ROOM <?=$_code_room?></title>
  <?php
  include "headers_scripts.php";
  ?>
  <link rel="stylesheet" href="css/room.css">
  <script src="javascript/room.js" defer></script>
  <link href="vendors/lightbox/css/lightbox.css" rel="stylesheet" />
</head>

<body class="falcon-body ">
  <?php include "header.php"; ?>
  <main id="main_content" class="schedule">

  <div class="room_header">
    <div class="room_details">
      <h2>Room</h2>
      <p class="room_title"><?= $_name_room ?></p>
      <ul>
        <li><div><i class="fa-solid fa-person-chalkboard"></i> <?= $_type_room ?></div></li>
        <li><div><i class="fa-solid fa-toggle-on"></i> <?= $_status_room ?></div></li>
        <li><div><i class="fa-regular fa-building"></i> <?= get_field_building(get_field_floor(get_field_room($_id_room, 'id_floor'), 'id_building'), 'name_building'); ?></div></li>
        <li><div><i class="fa-solid fa-layer-group"></i> <?=get_field_floor(get_field_room($_id_room,'id_floor'),'name_floor')?></div></li>
        
      </ul>
      <div class="room_button"><a href="#" class="btn btn-success <?= check_preference($_SESSION['ID_USER'], $id) ? 'selected' : '' ?>" alt="<?= check_preference($_SESSION['ID_USER'], $id) ? 'Remove favorite' : 'Add favorite' ?>" title="<?= check_preference($_SESSION['ID_USER'], $id) ? 'Remove favorite' : 'Add favorite' ?>" onclick="<?= check_preference($_SESSION['ID_USER'], $id) ? "confirm_del_preference(logged_user_id,'".$_id_room."','".$_code_room."');" : "addPreference(logged_user_id,'".$_id_room."','".$_code_room."');" ?>" alt="" id="btn-favorites" style="text-transform: uppercase; display:flex; gap:.5rem; align-items: center;"><i class="<?= check_preference($_SESSION['ID_USER'], $id) ? 'fa-solid fa-xmark' : 'fa-regular fa-heart' ?> fa-2xl"></i> <?= check_preference($_SESSION['ID_USER'], $id) ? 'Remove favorite' : 'Add favorite' ?></a></div>
    </div>
    
      <div class="room_images_container">
      <?php

$dir = $_image3d_room;

// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      if(!empty($file)&&$file!='.'&&$file!='..')
      echo '<a href="'.$dir.$file.'" data-lightbox="room_pics" data-title="Images for room: '.$_name_room.' "><img src="'.$dir.$file.'" alt="Images for room: '.$_name_room.'"><div class="room_pic_overlay"><i class="fa-solid fa-magnifying-glass-plus fa-beat-fade fa-2xl"></i></div></a>';
    }
    closedir($dh);
  }
}else{
  $array_pics_placeholders=["images/langara1.jpg","images/langara2.jpg","images/langara3.jpg"];
  foreach($array_pics_placeholders as $key => $value){
    echo '<a href="'.$value.'" data-lightbox="room_pics" data-title="Images for room: '.$_name_room.' "><img src="'.$value.'" alt="Images for room: '.$_name_room.'"><div class="room_pic_overlay"><i class="fa-solid fa-magnifying-glass-plus fa-beat-fade fa-2xl"></i></div></a>';
  }

}
?>
        
    </div>

    </div>
    <div class="maps_container">
      <div class="room_building">
      <div class="room_btns" style="">
      
      
      <a href="map-list.php" class="btn btn-success"><i class="fa-solid fa-building fa-xl"></i> Back to maps</a>
      </div>
      
      <object type="text/html" data="map-alone.php?active_building=<?= get_field_building(get_field_floor(get_field_room($_id_room, 'id_floor'), 'id_building'), 'code_building'); ?>&disabled=on" id="map_obj" style="height:400px"></object>
        <!-- <img src="images/<?= get_field_building(get_field_floor(get_field_room($_id_room, 'id_floor'), 'id_building'), 'code_building'); ?>.svg" alt="A Building"> -->
      </div>
      <div class="separator">&nbsp;</div>
      <div class="room_map">
        <object type="text/html" data="map-building-alone.php?id_room=<?= $_id_room ?>&disabled=on" id="map_obj" style="height:400px"></object>
      </div>
    </div>


    

  </main>

  <?php include "footer.php"; ?>
  <script src="vendors/lightbox/js/lightbox.js"></script>
</body>

</html>