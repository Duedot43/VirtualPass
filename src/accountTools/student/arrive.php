<?php

/** 
 * Arrive a student
 * 
 * PHP version 8.1
 * 
 * @file     /src/accountTools/student/arrive.php
 * @category Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../../include/modules.php";


$config = parse_ini_file("../../../config/config.ini");
echo "<!-- //TODO HEADERS -->";
if (!isset($_GET['user'])) {
    echo "Your user is not set";
    exit();
}
if (!userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['user']))) {
    echo "That user does not exist!";
    exit();
}
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    //TODO Arrive
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
        exit();
    }
}