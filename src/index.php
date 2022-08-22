<?php
declare(strict_types=1);
include "include/modules.php";


$config = parse_ini_file("../config.ini");
sendSqlCommandRaw("CREATE DATABASE IF NOT EXISTS VirtualPass;", "root", $config['sqlRootPasswd']);
// redirect to the main page
if (!isset($_GET['room'])) {
    header('Location: /realIndex.php');
    exit();
}

//if the user cookie is not set then redirect to register
if (!isset($_COOKIE['id'])) {
    header('Location: /regUser.php');
}
