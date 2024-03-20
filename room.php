<?php
ini_set("max_execution_time", "0");
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";
$page_title="Room - ";
if(isset($_GET['id'])){
    $id=$_GET['id'];
}else{
    header('Location: map-list.php');
}
if(is_numeric($id)&&!empty($id)){
$query = "SELECT * from room WHERE id_room='" . $id . "'";
//echo $query;
$room_q_query = tep_db_query($query);
$total = mysqli_num_rows($room_q_query);

if ($total > 0) {

  while ($room_q = tep_db_fetch_array($room_q_query)) {

    $_id_room=$id;
    $_id_floor = $room_q['id_floor'];
    $_code_room = $room_q['code_room'];
    $_name_room = $room_q['name_room'];
    $_status_room = $room_q['status_room'];
    $_image3d_room = $room_q['image3d_room'];
    $_type_room = $room_q['type_room'];

    
  }
  $page_title.=$_name_room;
}else{
    header('Location: map-list.php');
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
    <link rel="stylesheet" href="css/room.css">
    <script src="javascript/room.js" defer></script>
    
</head>
<body class="falcon-body ">
    <?php include "header.php"; ?>
    <main id="main_content" class="schedule">
   

    <div class="room_details">
      <h2>Code:</h2>
      <p><?=$_code_room?></p>
      <h2>Name:</h2>
      <p><?=$_name_room?></p>
      <h2>Status:</h2>
      <p><?=$_status_room?></p>
      <h2>Type of room:</h2>
      <p><?=$_type_room?></p>
      
    </div>
    <div class="room_building">
      <h2>Building</h2>
      <img src="images/<?=get_field_building(get_field_floor(get_field_room($_id_room,'id_floor'),'id_building'),'code_building');?>.svg" alt="A Building">
      <div class="room_btns">
        
        <a href="#" class="btn btn-success <?=check_preference($_SESSION['ID_USER'], $id)?'btn-circle-selected':'btn-circle'?>" alt="Add to favorites" title="Add to favorites" onclick="addPreference('<?=$_SESSION['ID_USER']?>','<?=$_id_room?>','<?=$_code_room?>')" id="btn-favorites"><i class="fa-regular fa-heart fa-2xl"></i> Add to my preferences</a>
        <a href="map-list.php" class="btn btn-success"><i class="fa-solid fa-building"></i> See on a Map</a>
</div>
    </div>
    <div class="room_map">
<object type="text/html" data="map-building-alone.php?id_room=<?=$_id_room?>&disabled=on" id="map_obj" ></object>
</div>
    
    
      <div class="room_images">
        <h2>Images of the room</h2>
        <div class="room_images_container">
        <img src="images/langara1.jpg" alt=""><img src="images/langara2.jpg" alt=""><img src="images/langara3.jpg" alt=""><img src="images/langara4.jpg" alt=""><img src="images/langara5.jpg" alt=""><img src="images/langara6.jpg" alt=""><img src="images/langara7.jpg" alt=""><img src="images/langara8.jpg" alt=""><img src="images/langara9.jpg" alt=""><img src="images/langara10.jpg" alt="">
            </div>
      </div>



    </main>

<?php include "footer.php"; ?>
</body>
</html>