<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>phpQr Demonstration</title>
</head>
<body>
<form action="qrcode-form.php">
  <label for="qrcodedata">QRCode data</label><input type="text" id="qrcodedata" name="qrcodedata"/><br/>
  <label for="width">Width</label><input type="text" id="width" name="width" value="256"/><br/>
  <label for="height">Height</label><input type="text" id="height" name="height" value="256"/><br/>
  <label for="quality">Quality</label><input type="text" id="quality" name="quality" value="50"/><br/>
  <input type="submit"/>
</form>
<?php 
if(isset($_GET['qrcodedata']) && strlen($_GET['qrcodedata']))
{
  $q = 50;
  $w = 256;
  $h = 256;
  if(isset($_GET['quality'])) $q = intval($_GET['quality']);
  if(isset($_GET['width'])) $w = intval($_GET['width']);
  if(isset($_GET['height'])) $h = intval($_GET['height']);
  
  printf('<img src="qrcode-display.php?data=%s&w=%d&h=%d&q=%d"/>', urlencode($_GET['qrcodedata']), $w, $h, $q);
}
?>
</body>
</html>