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


if (!isset($_COOKIE['teacherCookie']) or !teacherCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['teacherCookie']))) {
    header("Location: /teacher/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Teacher Portal</title>
    <meta name="color-scheme" content="dark light">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>


<body>

    <div class="b-card-container">
        <input class="reg" type="button" value="Make a room QR Code" onclick="location='/makeRoom/'" />
        <input class="reg" type="button" value="Search for your room" onclick="location='/teacher/search.php'" />
    </div>

    <script src="/include/mainScript.js"></script>


</body>


</html>