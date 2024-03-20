<?php 
header( 'Content-Type: text/html; charset=UTF-8' );
header( "Access-Control-Allow-Origin: *" );
$force_login=false;
include "includes/application_top.php";

if(isset($_GET['email'])){
$result['email']=$_GET['email'];
}
$result['result']=true;

echo json_encode($result);
?>