<?php
$rooms = exec("dir ../registerd_qrids/");
echo ("rooms: {$rooms} <br>");
$roomcont = exec("cat ../registerd_qrids/*");
echo ("roomc: {$roomcont} <br>");
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />