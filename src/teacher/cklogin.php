<?php
include "../include/modules.php";
$config = parse_ini_file("../../config/config.ini");
$domain = getDomain();

if (isset($_POST['uname']) and isset($_POST['passwd']) and authTeach("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^a-z.]+/i", "", $_POST['uname']), trim(trim($_POST['passwd'], '"'), "'"))) {
    $id = rand() . rand() . rand();
    setcookie("teacherCookie",$id, time()+3600, "/teacher", $domain, true, true);
    sendSqlCommand("INSERT teacherCookie VALUES('" . $id . "');", "root", $config['sqlRootPasswd'], "VirtualPass");
    header("Location: /teacher/menu.php");
}