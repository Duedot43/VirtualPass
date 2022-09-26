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
$teacher = authTeach($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^a-z.]+/i", "", $_POST['uname']), trim(trim($_POST['passwd'], '"'), "'"));
if (isset($_POST['uname']) and isset($_POST['passwd']) and $teacher[0]) {
    setcookie("teacherCookie", $teacher[1], time()+3600, "/", $domain, true, true);
    header("Location: /");
} else {
    echo "Username or password incorrect";
}