<?php

/** 
 * Check login file for the admin
 * 
 * PHP version 8.1
 * 
 * @file     /src/admin/cklogin.php
 * @category Authentication
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../include/modules.php";
$config = parse_ini_file("../../config/config.ini");
$domain = getDomain();
$admin = authAdmin(
    "root",
    $config['sqlRootPasswd'],
    "VirtualPass",
    preg_replace("/[^a-z.]+/i", "", $_POST['uname']),
    trim(trim($_POST['passwd'], '"'), "'")
);
if (isset($_POST['uname']) and isset($_POST['passwd']) and $admin[0]) {
    setcookie("adminCookie", $admin[1], time() + 3600, "/", $domain, true, true);
    header("Location: /");
} else {
    echo "username or password incorrect";
}
