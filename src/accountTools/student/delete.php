<?php

/** 
 * Manage a student
 * 
 * PHP version 8.1
 * 
 * @file     /src/accountTools/student/index.php
 * @category Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../../include/modules.php";


$config = parse_ini_file("../../../config/config.ini");
echo "<!-- HEADERS -->";
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
    $output = sendSqlCommand("DELETE FROM users WHERE sysID='" . htmlspecialchars(preg_replace("/[^0-9.]+/i", "", $_GET['user']),  ENT_QUOTES, 'UTF-8') . "';", "root", $config['sqlRootPasswd'], "VirtualPass");
    if ($output[0] == 1) {
        echo "Something went wrong with deleting the user!";
        exit();
    }
    echo "Success! User deleted!";
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
