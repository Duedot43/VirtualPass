<?php
/** 
 * Check login file for teachers
 * 
 * PHP version 8.1
 * 
 * @file     /src/teacher/cklogin.php
 * @category Authentication
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../include/modules.php";
$config = parse_ini_file("../../config/config.ini");
$domain = getDomain();

if (isset($_POST['uname']) and isset($_POST['passwd']) and authTeach("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^a-z.]+/i", "", $_POST['uname']), trim(trim($_POST['passwd'], '"'), "'"))) {
    $id = rand() . rand() . rand();
    setcookie("teacherCookie", $id, time()+3600, "/", $domain, true, true);
    sendSqlCommand("INSERT teacherCookie VALUES('" . $id . "');", "root", $config['sqlRootPasswd'], "VirtualPass");
    header("Location: /teacher/menu.php");
}