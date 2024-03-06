<?php
/**
 * This file is part of the phpQr package
 *
 * See @see QRCode class for description of package and license.
 */

set_include_path(
  get_include_path() . 
  PATH_SEPARATOR .
  '../src'
);

require_once 'QRErrorCorrectLevel.php';
require_once 'QRCode.php';
require_once 'QRCodeImage.php';

require_once '../ErrorHandler.php';
require_once '../SimpleLogger.php';

$outputFile = "unicode-test.jpg";

try
{
  $code = new QRCode(-1, QRErrorCorrectLevel::H);
  $code->addData("Some latin1 data");
  $code->addData(html_entity_decode("&#5792;&#5831;&#5819;&#5867;&#5842;&#5862;&#5798;&#5867;&#5792;&#5809;&#5801;&#5792;&#5794;&#5809;&#5867;&#5792;&#5825;&#5809;&#5802;&#5867;&#5815;&#5846;&#5819;&#5817;&#5862;&#5850;&#5811;&#5794;&#5847;", ENT_QUOTES, 'UTF-8'));
  $code->make();
  
  $img = new QRCodeImage($code, 256, 256, 50);
  $img->draw();
  $img->store($outputFile);
  $img->finish();
  
  if(file_exists($outputFile))
  {
    if(php_sapi_name() != 'cli')
    {
      printf('<img src="$outputFile"/>');
    }
    else
    {
      printf("File was created at %s/%s", dirname(__FILE__), $outputFile);      
    }
  }
}
catch (Exception $ex)
{
  echo $ex->getMessage() . "\n";
  echo $ex->getTraceAsString() . "\n";
  
  SimpleLogger::logException($ex);
}