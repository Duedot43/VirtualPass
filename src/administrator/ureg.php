<?php
$rooms = exec("dir ../registered_phid/");
echo ("Users: {$rooms} <br>");
$roomcont = exec("cat ../registered_phid/*");
echo ("Usrinfo: {$roomcont} <br>");
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />