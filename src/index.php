<?php

/** 
 * Home page and navigator
 * 
 * PHP version 8.1
 * 
 * @file     /src/index.php
 * @category Redirect+Home_Page
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */

declare(strict_types=1);
require "include/modules.php";
$domain = getDomain();


$config = parse_ini_file("../config/config.ini");

//create everything if it does not exist
sendSqlCommandRaw("CREATE DATABASE IF NOT EXISTS VirtualPass;", "root", $config['sqlRootPasswd']);
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS users (
    sysID varchar(255) NOT NULL,
    firstName varchar(255),
    lastName varchar(255),
    ID varchar(255),
    email varchar(255),
    activ varchar(1),
    misc LONGTEXT,
    PRIMARY KEY (sysID)

);",
    "root",
    $config['sqlRootPasswd'],
    "VirtualPass"
);
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS rooms (
    ID varchar(255) NOT NULL,
    num varchar(255),
    PRIMARY KEY (ID)

);",
    "root",
    $config['sqlRootPasswd'],
    "VirtualPass"
);
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS history (
    snTime varchar(255) NOT NULL,
    snOut varchar(255),
    snIn varchar(255),
    userReg varchar(255),
    roomReg varchar(255),
    PRIMARY KEY (snTime)

);",
    "root",
    $config['sqlRootPasswd'],
    "VirtualPass"
);
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS admins (
    uname varchar(255) NOT NULL,
    passwd varchar(255),
    PRIMARY KEY (uname)

);",
    "root",
    $config['sqlRootPasswd'],
    "VirtualPass"
);
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS teachers (
    uname varchar(255) NOT NULL,
    passwd varchar(255),
    PRIMARY KEY (uname)

);",
    "root",
    $config['sqlRootPasswd'],
    "VirtualPass"
);
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS teacherCookie (
    cookie varchar(255) NOT NULL,
    PRIMARY KEY (cookie)

);",
    "root",
    $config['sqlRootPasswd'],
    "VirtualPass"
);
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS adminCookie (
    cookie varchar(255) NOT NULL,
    PRIMARY KEY (cookie)

);",
    "root",
    $config['sqlRootPasswd'],
    "VirtualPass"
);
// redirect to the main page
if (!isset($_GET['room'])) {
    header('Location: /realIndex.php');
    exit();
}

if (!roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
    header('Location: /regRoom.php?room=' . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
}

//if the user cookie is not set then redirect to register
if (!isset($_COOKIE['id'])) {
    header('Location: /regUser.php?room=' . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
} elseif (!userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']))) {
    setcookie("id", "", time() - 31557600, "/", $domain, true, true);
    header('Location: /regUser.php?room=' . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
}



if (isset($_COOKIE['id']) and userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']))) {
    echo "<input type='button' onclick'Location=\"/doActiv.php?room=" . htmlspecialchars(preg_replace("/[^0-9.]+/i", "", $_GET['page']), ENT_QUOTES, 'UTF-8') . "\"'>";
}
