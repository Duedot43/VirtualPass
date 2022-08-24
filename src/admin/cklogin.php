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

if (isset($_POST['uname']) and isset($_POST['passwd'])
    and authAdmin(
        "root",
        $config['sqlRootPasswd'],
        "VirtualPass",
        preg_replace("/[^a-z.]+/i", "", $_POST['uname']),
        trim(trim($_POST['passwd'], '"'), "'")
    )
) {
    $id = rand() . rand() . rand();
    setcookie("adminCookie", $id, time() + 3600, "/", $domain, true, true);
    sendSqlCommand(
        "INSERT adminCookie VALUES('" . $id . "');",
        "root",
        $config['sqlRootPasswd'],
        "VirtualPass"
    );
    header("Location: /admin/menu.php");
} else {
    echo "username or password incorrect";
}
