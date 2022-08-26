<?php

/** 
 * Manage an admin
 * 
 * PHP version 8.1
 * 
 * @file     /src/accountTools/admin/index.php
 * @category Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../include/modules.php";


$config = parse_ini_file("../../config/config.ini");
echo "<!-- HEADERS -->";
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    // view admin accounts
    // delete admin account
    // change uname or password
    // import admins
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
        exit();
    }
}