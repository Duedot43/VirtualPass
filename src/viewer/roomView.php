<?php

/** 
 * Room viewer
 * 
 * PHP version 8.1
 * 
 * @file     /src/viewer/roomView.php
 * @category Display
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../include/modules.php";


$config = parse_ini_file("../../config/config.ini");
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <title>Room viewer</title>
    <meta name="color-scheme" content="dark light">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>';
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie'])) or isset($_COOKIE['teacherCookie']) and teacherCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['teacherCookie']))) {
    //get all the rooms
    $result = sendSqlCommand("SELECT * FROM rooms;", "root", $config['sqlRootPasswd'], "VirtualPass");
    while ($row = mysqli_fetch_assoc($result[1])) {
        echo "<button onclick=\"location='/viewer/stuRoomView.php?room=" . $row['ID'] . "'\" >" . $row['num'] . "</button><br>";
        
        //Onclick is usually used for JS Functions.
    }
    exit();
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
        exit();
    }
}