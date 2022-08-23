<?php
include "../include/modules.php";
$config = parse_ini_file("../../config/config.ini");


if (!isset($_COOKIE['teacherCookie']) or !teacherCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    header("Location: /teacher");
    exit();
}
?>
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Portal</title>



<input class="reg" type="button" value="View all user info" onclick="location='/viewer/studentView.php?refer=teacherCookie'" />
<input class="reg" type="button" value="Make a room QR Code" onclick="location='/mk_room/index.php'" />
<input class="reg" type="button" value="View all rooms" onclick="location='view_rooms.php'" />