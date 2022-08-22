<?php
declare(strict_types=1);
include "include/modules.php";
$domain = getDomain();


$config = parse_ini_file("../config/config.ini");

//create everything if it does not exist
sendSqlCommandRaw("CREATE DATABASE IF NOT EXISTS VirtualPass;", "root", $config['sqlRootPasswd']);
sendSqlCommand("CREATE TABLE IF NOT EXISTS users (
    sysID varchar(255) NOT NULL,
    firstName varchar(255),
    lastName varchar(255),
    ID varchar(255),
    email varchar(255),
    PRIMARY KEY (sysID)

);", "root", $config['sqlRootPasswd'], "VirtualPass");
sendSqlCommand("CREATE TABLE IF NOT EXISTS rooms (
    ID varchar(255) NOT NULL,
    num varchar(255),
    PRIMARY KEY (ID)

);", "root", $config['sqlRootPasswd'], "VirtualPass");

// redirect to the main page
if (!isset($_GET['room'])) {
    header('Location: /realIndex.php');
    exit();
}

if (!roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
    header('Location: /regRoom.php?room=' . $_GET['room']);
    exit();
}

//if the user cookie is not set then redirect to register
if (!isset($_COOKIE['id'])) {
    header('Location: /regUser.php?room=' . $_GET['room']);
    exit();
} elseif (!userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']))) {
    setcookie("id", "", time()-31557600, "/", $domain, true, true);
    header('Location: /regUser.php?room=' . $_GET['room']);
    exit();
}



if ( isset($_COOKIE['id']) and userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']))) {

}
