<?php
  require('includes/configure.php');
header('Content-Type: text/html; charset=UTF-8');
session_start();

	
  require(DIR_FUNCTIONS . 'database.php');

  tep_db_connect() or die('Unable to connect to database server!');
    tep_db_query("SET NAMES 'utf8'");
  require(DIR_FUNCTIONS .'general.php');



$_GET=clean_vars($_GET);
$_POST=clean_vars($_POST);
$_REQUEST=clean_vars($_REQUEST);

 ?>