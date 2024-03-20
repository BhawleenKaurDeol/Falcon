<?php
ini_set('max_execution_time', '0');
header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";
$search_campus='-';
if(isset($_GET['search_campus'])){
    $search_campus=$_GET['search_campus'];
}
$search_building='-';
if(isset($_GET['search_building'])){
    $search_building=$_GET['search_building'];
}
$search_floor='-';
if(isset($_GET['search_floor'])){
    $search_floor=$_GET['search_floor'];
}
$search_room='';
if(isset($_GET['search_room'])){
    $search_room=$_GET['search_room'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script src="https://kit.fontawesome.com/6155c8fec8.js" crossorigin="anonymous"></script>
    <script src="vendors/sweetalert/sweetalert-v2.11.js"></script>
    <script src="vendors/jquery/jquery-3.4.1.js"></script>
    <link href="vendors/select2/css/select2.min.css" rel="stylesheet" />
<script src="vendors/select2/js/select2.min.js"></script>
    <link rel="stylesheet" href="css/styles.css">

    <link rel="icon" type="image/png" href="images/falcon-icon.png">
    <script src="javascript/map-list.js" defer></script>
    <link rel="stylesheet" href="css/map-list.css">
</head>

<body class="falcon-body">
    <?php 
    include "header.php";
    ?>
    
    <div class="map_list_container">
        <main>
        <div class="map_list">
        <form action="map-list.php" method="get" id="form-map-list">

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
        <option value="<?=$code_room?>"><?=$name_room?></option>
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
        <div class="list">
            <ul class="campus_list">
                <?php
                $query = "SELECT * from campus where id_campus='1' order by id_campus";
            //  if($search_campus!='-'){
            //     $query = "SELECT * from campus where id_campus='$search_campus' order by id_campus";
            // }
                $map_query = tep_db_query($query);
                $total = mysqli_num_rows($map_query);
        
                if ($total > 0) {
                $i=0;
                  while ($campus = tep_db_fetch_array($map_query)) {
                    $id_campus = $campus['id_campus'];
                    $name_campus = $campus['name_campus'];
              ?>
                <li><h2><?=$name_campus?></h2>
                <?php
                 $query_building = tep_db_query("SELECT * from building WHERE id_campus='$id_campus'");
                 if($search_building!='-'){
                    $query_building = tep_db_query("SELECT * from building WHERE id_building='$search_building'");
                }
        
                $total_b = mysqli_num_rows($query_building);
        
                if ($total_b > 0) {
                    ?>
                    <ul class="building_list">
                    <?php
        
                  while ($building = tep_db_fetch_array($query_building)) {
                    $id_building = $building['id_building'];
                    $name_building = $building['name_building'];
                    ?>
                    <li><input type="checkbox" name="list-building" class="list-building" id="list-building-<?=$id_building?>" onchange="fetch_foors('<?=($search_floor!='-')?$search_floor:$id_building?>','list-building-<?=$id_building?>')">
                    <label for="list-building-<?=$id_building?>"><?=$name_building?><span class="icon_caret"></span></label>
                    <div id="list-building-<?=$id_building?>-child" class="list-building-child"><div class="lds-dual-ring"></div></div>
                    </li>
                    <?php
                  }
                  ?>
        </ul>
                  <?php
                }
                    ?>
            </li>
                <?php
          $i++;  }
        }
        ?>
            </ul>
        </div>
        </div>
        </main>
        <aside id="map_loader">
        </aside>
    </div>
    <?php
include "footer.php";
?>

<script>
    <?php if($search_building!='-'&&$total_b>0){ ?>
document.getElementById('list-building-<?=$search_building?>').checked = true; fetch_foors('<?=($search_floor!='-'?$search_floor:$search_building)?>','list-building-<?=$search_building?>'); 
<?php } 
//if(!empty($search_room)){
    echo 'let search_room="'.$search_room.'"';
//}
?>

async function fetch_foors(building_id, element_html, load='yes') {
    let checkbox=document.getElementById(element_html);
let all_buildings=document.getElementsByClassName('list-building');



for (var i = 0; i < all_buildings.length; i++) {

        if(all_buildings[i].id!=element_html){
            all_buildings[i].checked = false;
        }

    }
    checkbox.checked;
    let div=document.getElementById(element_html+'-child');
    if(checkbox.checked){
        if(load=='yes'){
        load_map('map-building-'+building_id);
    }
    const response = await fetch("api.php?id="+building_id+"&t=<?=($search_floor!='-')?'floor-Id':'building-Id-floor'?>&token=XXX");
    
    
    const result = await response.json();
    console.log(result);
    let return_html='<ul class="floor_list">';
    <?=($search_floor!='-')?'let newfetch= await fetch_rooms2(building_id,\'list-floor-\'+building_id)':''?>
    ;
    result.forEach(element => {
        
        return_html+='<li><input type="checkbox" name="list-floor" class="list-floor" id="list-floor-'+element.id_floor+'" onchange=fetch_rooms(\''+element.id_floor+'\',\'list-floor-'+element.id_floor+'\') <?=($search_floor!='-')?'\'+(building_id==element.id_floor?\'checked\':\'\')+\'':''?>><label for="list-floor-'+element.id_floor+'">'+element.name_floor+'<span class="icon_plus"></span></label><div id="list-floor-'+element.id_floor+'-child" class="list-floor-child"><?=($search_floor!='-')?'\'+ newfetch +\'':'<div class="lds-dual-ring"></div>'?></div></li>';
    });
    return_html+='</ul>'
    div.innerHTML=return_html;
    
    }else{
        load_map();
    div.innerHTML='<div class="lds-dual-ring"></div>';
    }
  }
  async function fetch_rooms(floor_id, element_html) {
    let checkbox=document.getElementById(element_html);
    let all_floors=document.getElementsByClassName('list-floor');
//console.log(all_buildings);
for (var i = 0; i < all_floors.length; i++) {

        if(all_floors[i].id!=element_html){
            all_floors[i].checked = false;
        }

    }
    let div=document.getElementById(element_html+'-child');
    if(checkbox.checked){
    const response = await fetch("api.php?id="+floor_id+"&t=floor-Id-room&token=XXX");
    const result = await response.json();
    console.log(result);
    let return_html='<ul class="room_list">';
    result.forEach(element => {
if(element.name_room.toLowerCase().includes(search_room.toLowerCase())){
        return_html+='<li>'+element.name_room+'<div class="menu_room_list"><a onclick="confirm_favorite(\''+element.id_room+'\',\''+element.name_room+'\')"><i class="fa-regular fa-heart"></i></a> <a href="room.php?=id='+element.id_room+'"><i class="fa-solid fa-location-pin"></i></a> <a href="room.php?=id='+element.id_room+'"><i class="fa-solid fa-chalkboard-user"></i></a></div></li>';
    }
    });
    return_html+='</ul>';
    div.innerHTML=return_html;
    }else{
    div.innerHTML='<div class="lds-dual-ring"></div>';
    }
   
  }
  async function fetch_rooms2(floor_id, element_html) {
   // let checkbox=document.getElementById(element_html);
   // let div=document.getElementById(element_html+'-child');
   // if(checkbox.checked){
    const response = await fetch("api.php?id="+floor_id+"&t=floor-Id-room&token=XXX");
    const result = await response.json();
    console.log(result);
    let return_html='<ul class="room_list">';
    result.forEach(element => {
        if(element.name_room.toLowerCase().includes(search_room.toLowerCase())){
        return_html+='<li>'+element.name_room+'<div class="menu_room_list"><a onclick="confirm_favorite(\''+element.id_room+'\',\''+element.name_room+'\')"><i class="fa-regular fa-heart"></i></a> <a href="room.php?=id='+element.id_room+'"><i class="fa-solid fa-location-pin"></i></a> <a href="room.php?=id='+element.id_room+'"><i class="fa-solid fa-chalkboard-user"></i></a></div></li>';
        }
    });
    return_html+='</ul>';
   return return_html;
   // }else{
   // div.innerHTML='<div class="lds-dual-ring"></div>';
   // }
   
  }

 function confirm_favorite(id_room,name_room){
    Swal.fire({
        title: "Do you want to add "+name_room+" to your favorites?",
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No"
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
         // Swal.fire("Saved!", "", "success");
         //call API to save
        } 
      });
  }

  function load_map(url_fin=''){
    //
       
    document.getElementById("map_loader").innerHTML='<object type="text/html" data="map-alone.php?selected='+url_fin+'" id="map_obj" style=" width: 100%;    height: calc(100vh - 130px);    display: block;" ></object>';
        }
        load_map();
  </script>
  <script>
    $(document).ready(function() {
    $('#search_room').select2({
        placeholder: 'Search for a classroom or office',
        closeOnSelect: true,
    allowClear: true,
    width: 'resolve',
    
    });
});
</script>
</body>

</html>