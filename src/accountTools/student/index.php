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
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage students</title>
    <meta name="color-scheme" content="dark light">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>';
if (!isset($_GET['user'])) {
    echo "Your user is not set";
    exit();
}
if (!userExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['user']))) {
    echo "That user does not exist!";
    exit();
}
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
        exit();
    }
}
?>
<button onclick="AJAXGet('/accountTools/student/change.php?user=<?php echo htmlspecialchars($_GET['user'],  ENT_QUOTES, 'UTF-8'); ?>', 'mainEmbed')">Change Info</button>
<button onclick="AJAXGet('/accountTools/student/arrive.php?user=<?php echo htmlspecialchars($_GET['user'],  ENT_QUOTES, 'UTF-8'); ?>', 'mainEmbed')">Force Arrive</button>
<button onclick="AJAXGet('/accountTools/student/delete.php?user=<?php echo htmlspecialchars($_GET['user'],  ENT_QUOTES, 'UTF-8'); ?>', 'mainEmbed')">Delete User</button>
<button onclick="AJAXGet('/accountTools/student/import.php', 'mainEmbed')">Import Users</button>