<?php

/** 
 * See what students are in a specific room
 * 
 * PHP version 8.1
 * 
 * @file     /src/viewer/stuRoomView.php
 * @category Display
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../include/modules.php";


$config = parse_ini_file("../../config/config.ini");
echo "<!-- //TODO HEADERS -->";
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie'])) or isset($_COOKIE['teacherCookie']) and teacherCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['teacherCookie']))) {
    //see if we have a room to request and if that room exists
    if (!isset($_GET['room']) or !roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
        echo "That room either does not exist or is not set";
        exit();
    }

    if (isset($_COOKIE['adminCookie'])) {
        echo "<button onclick=\"location='/accountTools/rooms/?room=" . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8') . "'\" >Manage this room</button>";
    }
    $result = sendSqlCommand("SELECT * FROM users;", "root", $config['sqlRootPasswd'], "VirtualPass");
    while ($row = mysqli_fetch_assoc($result[1])) {
        if (in_array($_GET['room'], json_decode($row['misc'], true)['rooms'])) {
            echo "<button onclick=\"location='/viewer/studentView.php?user=" . $row['sysID'] . "'\" >" . $row['firstName'] . " " . $row['lastName'] . " " . activ2eng($row['activ']) . "</button><br>";
            
        }
    }
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
        exit();
    }
}
