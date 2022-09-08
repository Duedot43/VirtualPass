<?php

/** 
 * Manage a room
 * 
 * PHP version 8.1
 * 
 * @file     /src/accountTools/rooms/index.php
 * @category Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../../include/modules.php";


$config = parse_ini_file("../../../config/config.ini");
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage room</title>
    <meta name="color-scheme" content="dark light">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>';
if (!isset($_GET['room'])) {
    echo "Your room is not set";
    exit();
}
if (!roomExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
    echo "That room does not exist!";
    exit();
}
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    // change room num
    // delete room

    // Delete room
    if (isset($_GET['action']) and $_GET['action'] == "delete") {
        $output = sendSqlCommand("DELETE FROM rooms WHERE ID='" . htmlspecialchars(preg_replace("/[^0-9.]+/i", "", $_GET['room']),  ENT_QUOTES, 'UTF-8') . "';", "root", $config['sqlRootPasswd'], "VirtualPass");
        if ($output[0] == 1) {
            echo "Something went wrong with deleting the room!";
            exit();
        }
        $result = sendSqlCommand("SELECT * FROM users;", "root", $config['sqlRootPasswd'], "VirtualPass");
        while ($row = mysqli_fetch_assoc($result[1])) {
            $misc = json_decode($row['misc']);
            if (in_array($_GET['room'], $misc['rooms'])) {
                $key = array_search($_GET['room'], $misc['rooms']);
                unset($misc['rooms'][$key]);
                sendSqlCommand(
                    "UPDATE users 
                SET 
                    misc = '" . json_encode($misc) . "'
                WHERE
                    sysId=" . preg_replace("/[^0-9.]+/i", "", $row['sysID']) . ";",
                    "root",
                    $config['sqlRootPasswd'],
                    "VirtualPass"
                );
            }
        }
    }

    //print the main stuff
    $room = getRoomData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['room']));
    echo "<button onclick=\"location='/accountTools/rooms/change.php?room=" . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8') . "'\" >Change room number</button>";
    echo "<button onclick=\"location='/accountTools/rooms/?room=" . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8') . "&action=delete'\" >Delete the room</button>";
    echo "<button onclick=\"location='/accountTools/rooms/import.php'\" >Import room DB</button>";
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
        exit();
    }
}
