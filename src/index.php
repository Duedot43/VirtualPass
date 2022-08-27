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
    uuid varchar(255),
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
    uuid varchar(255),
    PRIMARY KEY (uname)

);",
    "root",
    $config['sqlRootPasswd'],
    "VirtualPass"
);
// perm 0 is regular user they can access their info and either depart or arrive and can view only their real room numbers
// perm 1 is regular user they can edit their basic info and do all level 0 can
// perm 2 is administrator they can view all users view all rooms
// perm 3 is full administrator they can view and change admin and teacher password view all users and rooms edit all users and rooms and delete all users and rooms
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS apiKeys (
    apiKey varchar(255) NOT NULL,
    perms varchar(255),
    user varchar(255),
    PRIMARY KEY (apiKey)

);",
    "root",
    $config['sqlRootPasswd'],
    "VirtualPass"
);
// redirect to the main page
if (!isset($_GET['room'])) {
    header('Location: /home.html');
    exit();
}

if (!roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
    echo "That room does not exist! Please contact an administrator.";
    //header('Location: /regRoom.php?room=' . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
}

//if the user cookie is not set then redirect to register
if (!isset($_COOKIE['id'])) {
    header('Location: /login.php?room=' . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
} elseif (!userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']))) {
    setcookie("id", "", time() - 31557600, "/", $domain, true, true);
    header('Location: /login.php?room=' . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
}



if (isset($_COOKIE['id']) and userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']))) {
    echo "<input type='button' onclick'Location=\"/doActiv.php?room=" . htmlspecialchars(preg_replace("/[^0-9.]+/i", "", $_GET['room']), ENT_QUOTES, 'UTF-8') . "\"'>";
}
