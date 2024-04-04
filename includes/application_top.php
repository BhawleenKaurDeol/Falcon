<?php
  require('includes/configure.php');
header('Content-Type: text/html; charset=UTF-8');
session_start();
if(!isset($force_login)){
$force_login=true;
}
if($force_login==true){
if(str_starts_with(basename($_SERVER['PHP_SELF']),'login')){
	if(basename($_SERVER['PHP_SELF'])=='login.php'){
  session_destroy();
  }
}else{
  
if(!isset($_SESSION['ID_USER'])){
  header('Location: login.php');
}else{
  $id_user_session=$_SESSION['ID_USER'];
}
}
}

//	print_r($_SESSION);
  require(DIR_FUNCTIONS . 'database.php');

  tep_db_connect() or die('Unable to connect to database server!');
    tep_db_query("SET NAMES 'utf8'");
  require(DIR_FUNCTIONS .'general.php');

$_GET=clean_vars($_GET);
$_POST=clean_vars($_POST);
$_REQUEST=clean_vars($_REQUEST);

 ?>