<?php
$rooms = exec("dir ../registered_phid/ && dir ../departed/");
echo ("Users: {$rooms} <br>");
$roomcont = exec("cat ../registered_phid/* && cat ../departed");
echo ("Usrinfo: {$roomcont} <br>");
?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />