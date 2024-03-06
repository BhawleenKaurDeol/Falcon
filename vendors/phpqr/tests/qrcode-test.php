<?php
/**
 * This file is part of the phpQr package
 *
 * See @see QRCode class for description of package and license.
 */
ini_set('display_errors', 1);
error_reporting(-1);

set_include_path(
  get_include_path() . 
  PATH_SEPARATOR .
  '../src'
);

require_once 'QRErrorCorrectLevel.php';
require_once 'QRCode.php';
require_once 'QRCodeImage.php';

try
{
  $code = new QRCode(-1, QRErrorCorrectLevel::H);
  $code->addData("http://www.phpclasses.org");
  $code->make();
  
  $img = new QRCodeImage($code, 256, 256, 10);
  $img->draw();
  $img->store("test.jpg");
  $img->finish();
}
catch (Exception $ex)
{
  echo $ex->getMessage() . "\n";
  echo $ex->getTraceAsString() . "\n";
}