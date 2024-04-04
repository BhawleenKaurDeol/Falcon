<?php

header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
$force_login=false;
include "includes/application_top.php";


if(isset($_GET['logout'])){
// unset($_SESSION['USER_FALCON']);
session_destroy();
header('location:login.php');	
}
if((isset($_GET['student_id']))&&(!isset($_POST['password_student']))){
	$student_id=$_GET['student_id'];
	$result['student_id_exists'] = 'false';
	if(student_id_consulta($student_id)==true){
$result['student_id_exists'] = 'true';
	}
}
$result['login'] =  'false';	
if((isset($_POST['student_id']))&&(isset($_POST['password_student']))){
	$student_id=$_POST['student_id'];
	$password=$_POST['password_student'];
	
	
	
	if(login_consulta($student_id,$password)==true){
        login_session($student_id,$password);

$result['login'] = 'true';
	}
}
//$result['post']=$_REQUEST;
//print_r($result);
echo json_encode($result);
?>