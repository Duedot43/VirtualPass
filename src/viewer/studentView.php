<?php

/** 
 * Student Viewer
 * 
 * PHP version 8.1
 * 
 * @file     /src/viewer/studentView.php
 * @category Display
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../include/modules.php";


$config = parse_ini_file("../../config/config.ini");
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <title>View students</title>
    <meta name="color-scheme" content="dark light">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>';
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie'])) or isset($_COOKIE['teacherCookie']) and teacherCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['teacherCookie']))) {
    if (isset($_GET['user']) and isset($_GET['date']) and isset($_GET['room'])) {
        if (!userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['user']))) {
            echo "That user does not exist.";
            exit();
        }
        $user = getUserData("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['user']));
        $miscData = json_decode($user['misc'], true);
        if (!isset($miscData['activity'][$_GET['date']])) {
            echo "That date does not exist";
            exit();
        }
        if (!in_array($_GET['room'], $miscData['rooms'])) {
            echo "That room does not exist";
            exit();
        }
        $dateArr = $miscData['activity'][$_GET['date']];
        foreach ($dateArr as $occorance) {
            if ($occorance['room'] == $_GET['room']) {
                echo htmlspecialchars($user['firstName'],  ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($user['lastName'],  ENT_QUOTES, 'UTF-8') . " departed from room " . htmlspecialchars($occorance['room'],  ENT_QUOTES, 'UTF-8') . " they were gone for " . gmdate("H:i:s", $occorance['timeArv'] - $occorance['timeDep']) . "<br>";
            }
        }
        exit();
    }
    if (isset($_GET['user']) and isset($_GET['date'])) {
        if (!userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['user']))) {
            echo "That user does not exist.";
            exit();
        }
        $user = getUserData("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['user']));
        $miscData = json_decode($user['misc'], true);
        if (!isset($miscData['activity'][$_GET['date']])) {
            echo "That date does not exist";
            exit();
        }
        $dateArr = $miscData['activity'][$_GET['date']];
        $rooms = array();
        foreach ($dateArr as $occorance) {
            if (!in_array($occorance['room'], $rooms)) {
                array_push($rooms, $occorance['room']);
                echo "<button onclick=\"location='/viewer/studentView.php?user=" . htmlspecialchars($_GET['user'],  ENT_QUOTES, 'UTF-8') . "&date=" . htmlspecialchars($_GET['date'],  ENT_QUOTES, 'UTF-8') . "&room=" . htmlspecialchars($occorance['room'],  ENT_QUOTES, 'UTF-8') . "'\" >" . htmlspecialchars($occorance['room'],  ENT_QUOTES, 'UTF-8') . "</button><br>";
            }
        }
        exit();
    }
    if (isset($_GET['user'])) {
        if (!userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['user']))) {
            echo "That user does not exist.";
            exit();
        }
        $user = getUserData("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", htmlspecialchars($_GET['user'],  ENT_QUOTES, 'UTF-8')));
        if (isset($_COOKIE['adminCookie'])) {
            echo "<button onclick=\"location='/accountTools/student/?user=" . htmlspecialchars($_GET['user'],  ENT_QUOTES, 'UTF-8') . "'\" >Manage this user</button>";
        }
        $miscData = json_decode($user['misc'], true);
        $array_keys = array_keys($miscData['activity']);
        foreach ($array_keys as $array_key) {
            echo "<button onclick=\"location='/viewer/studentView.php?user=" . htmlspecialchars($_GET['user'],  ENT_QUOTES, 'UTF-8') . "&date=" . $array_key . "'\" >" . $array_key . "</button>";
        }
        exit();
    }


    //cycle through all the users and display them
    $result = sendSqlCommand("SELECT * FROM users;", "root", $config['sqlRootPasswd'], "VirtualPass");
    while ($row = mysqli_fetch_assoc($result[1])) {
        echo "<button onclick=\"location='/viewer/studentView.php?user=" . $row['sysID'] . "'\" >" . $row['firstName'] . " " . $row['lastName'] . " " . activ2eng($row['activ']) . "</button><br>";
    }
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
        exit();
    }
}
