<?php

/** 
 * Menu for teacer
 * 
 * PHP version 8.1
 * 
 * @file     /src/teacher/menu.php
 * @category Display
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../include/modules.php";
$config = parse_ini_file("../../config/config.ini");


if (!isset($_COOKIE['teacherCookie']) or !teacherCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['teacherCookie']))) {
    header("Location: /teacher/login.html");
    exit();
}
?>
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher Portal</title>



<input class="reg" type="button" value="View all user info" onclick="location='/viewer/studentView.php'" />
<input class="reg" type="button" value="Make a room QR Code" onclick="location='/mk_room/index.php'" />
<input class="reg" type="button" value="View all rooms" onclick="location='view_rooms.php'" />
<input class="reg" type="button" value="View all rooms" onclick="location='/teacher/search.php'" />