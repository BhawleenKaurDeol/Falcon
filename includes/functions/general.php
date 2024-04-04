<?php
function clean_vars($array = array())
{
	$result = array();
	foreach ($array as $key => $value) {
		$result[$key] = str_replace("'", "\'", $value);
	}
	return $result;
}
function clean_vars_erase($array = array())
{
	$result = array();
	foreach ($array as $key => $value) {
		$result[$key] = str_replace("\'", "\u2019", $value);
	}
	return $result;
}

///////////////////////////////////
function get_active($url){
$result='';
//echo basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	if(basename($_SERVER['PHP_SELF'])==$url){
	$result='active';
}
if($url=='map-list.php'&&(basename($_SERVER['PHP_SELF'])=='map-building.php')){
	$result='active';
}

return $result;
}
function login_consulta($student_id,$password){

	$password=encode_password($password);

	$sql_login="select * from users where student_id='".$student_id."' and password='".$password."'";
$editar_query=tep_db_query($sql_login);
$total_records=mysqli_num_rows($editar_query);
if($total_records>0){
	return true;
}else{
	return false;
}

}
function student_id_consulta($student_id){

	$sql_login="select * from users where student_id='".$student_id."'";
$editar_query=tep_db_query($sql_login);
$total_records=mysqli_num_rows($editar_query);
if($total_records>0){
	return true;
}else{
	return false;
}

}
function login_session($student_id,$password){

	$password=encode_password($password);

	$sql_login="select * from users where student_id='".$student_id."' and password='".$password."'";
$login_query=tep_db_query($sql_login);


	while ($login = tep_db_fetch_array($login_query)) {
	
		$student_id= $login['id_user'];
	}
	$_SESSION['ID_USER']=$student_id;


}
function encode_password($password){
	// do the encoding
return $password;
}
function get_encoded_id($id){
	$result=$id;
	return $result;
}
function check_preference($id_user, $id_room){
	$result=false;
	$table='preferences';
    $query="select * from $table where id_user='$id_user' and id_room='$id_room'";
   
   $tep_query=tep_db_query($query); 
   $total=mysqli_num_rows($tep_query);
   if($total>0){
	$result=true;
   }
   
   return $result;
}
function get_field_room($id_room,$field){
	$result='';
    $query="select $field as result from room where id_room='$id_room'";
   
   $tep_query=tep_db_query($query); 
   while ($room = tep_db_fetch_array($tep_query)) {
    $result= $room['result'];
   }
  return $result;	
}
function get_field_building($id,$field){
	$result='';
    $query="select $field as result from building where id_building='$id'";
   
   $tep_query=tep_db_query($query); 
   while ($room = tep_db_fetch_array($tep_query)) {
    $result= $room['result'];
   }
  return $result;	
}
function get_field_floor($id_floor,$field){
	$result='';
    $query="select $field as result from floor where id_floor='$id_floor'";
   
   $tep_query=tep_db_query($query); 
   while ($floor = tep_db_fetch_array($tep_query)) {
	$result= $floor['result'];
   }
  return $result;	
}
function get_user_picture($id_user){
	$result='images/eagle.svg';
    $query="select picture as result from users where id_user='$id_user'";
   
   $tep_query=tep_db_query($query); 
   while ($floor = tep_db_fetch_array($tep_query)) {
	$result= $floor['result'];
   }
  // if(check_base64_image($picture)){
//	$result=$picture;
//  }
if($result==''){
	$result='images/placeholder-face.jpg';
}
  return $result;
}

function check_base64_image($base64) {
    $img = imagecreatefromstring($base64);
    if (!$img) {
        return false;
    }

    ob_start();
    if(!imagepng($img)) {

        return false;
    }
    $imageTemp = ob_get_contents(); 
    ob_end_clean();

    // Set a temporary global variable so it can be used as placeholder
    global $myImage; $myImage = "";

    $fp = fopen("var://myImage", "w");
    fwrite($fp, $imageTemp);
    fclose($fp);    

    $info = getimagesize("var://myImage");
    unset($myvar);
    unset($imageTemp);

    if ($info[0] > 0 && $info[1] > 0 && $info['mime']) {
        return true;
    }

    return false;
}

function get_salutation(){
	date_default_timezone_set('America/Vancouver'); //added line
    $b = time();
    $hour = date("g", $b);
    $m    = date("A", $b);
	// $hour=10;
	// $m='AM';
$result='';
    if ($m == "AM") {
      if ($hour == 12) {
        $result= "Good Evening!";
      } elseif ($hour < 4) {
        $result= "Good Evening!";
      } elseif ($hour > 3) {
        $result= "Good Morning!";
      }
    }
        elseif ($m == "PM") {
      if ($hour == 12) {
        $result= "Good Afternoon!";
      } elseif ($hour < 6) {
        $result= "Good Afternoon!";
      } elseif ($hour > 5) {
        $result= "Good Evening!";
      }
    }
	return $result;
}
function get_link_room_highlighted($id_room){
  $result='';
  $code_floor=get_field_floor(get_field_room($id_room,'id_floor'),'code_floor');
  $code_room=get_field_room($id_room,'code_room');
  $code_building=get_field_building(get_field_floor(get_field_room($id_room,'id_floor'),'id_building'),'code_building');
  $result="building=$code_building&active_room=$code_room&level=$code_floor";
return $result;
}

