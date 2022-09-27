<?php

/** 
 * Menu for admin
 * 
 * PHP version 8.1
 * 
 * @file     /src/admin/menu.php
 * @category Display
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../include/modules.php";
$config = parse_ini_file("../../config/config.ini");


if (!isset($_COOKIE['adminCookie'])
    or !adminCookieExists(
        $config['sqlUname'],
        $config['sqlPasswd'],
        $config['sqlDB'],
        preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie'])
    )
) {
    header("Location: /admin/login.html");
    exit();
}
// My lint program and my formatter are arguing this is not good
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Portal</title>
    <meta name="color-scheme" content="dark light">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/public/style.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>

<body>

    <div class="b-card-container">
        <button onclick="AJAXGet('/accountTools/teacher', 'mainEmbed')"> Manage Teacher Accounts </button>
        <button onclick="AJAXGet('/accountTools/admin', 'mainEmbed')"> Manage Admin Accounts </button>
        <button onclick="AJAXGet('/viewer/roomView.php', 'mainEmbed')"> View all rooms </button>
        <button onclick="AJAXGet('/viewer/studentView.php', 'mainEmbed')"> View all user info </button>
        <button onclick="AJAXGet('/makeRoom/', 'mainEmbed')"> Generate room QR code </button>
    </div>



</body>


</html>