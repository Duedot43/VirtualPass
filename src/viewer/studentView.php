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
echo "<!-- HEADERS -->";
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
                echo $user['firstName'] . " " . $user['lastName'] . " departed from room " . $occorance['room'] . " they were gone for " . gmdate("H:i:s", $occorance['timeArv'] - $occorance['timeDep']) . "<br>";
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
                echo "<button onclick='/viewer/studentView.php?user=" . $_GET['user'] . "&date=" . $_GET['date'] . "&room=" . $occorance['room'] . "' >" . $occorance['room'] . "</button><br>";
            }
        }
        exit();
    }
    if (isset($_GET['user'])) {
        if (!userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['user']))) {
            echo "That user does not exist.";
            exit();
        }
        $user = getUserData("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['user']));
        //TODO display user info in day room occorance format
        $miscData = json_decode($user['misc'], true);
        $array_keys = array_keys($miscData['activity']);
        foreach ($array_keys as $array_key) {
            echo "<button onclick='/viewer/studentView.php?user=" . $_GET['user'] . "&date=" . $array_key . "' >" . $array_key . "</button>";
        }
        exit();
    }


    //cycle through all the users and display them
    $result = sendSqlCommand("SELECT * FROM users;", "root", $config['sqlRootPasswd'], "VirtualPass");
    while ($row = mysqli_fetch_assoc($result[1])) {
        echo "<button onclick='/viewer/studentView.php?user=" . $row['sysID'] . "' >" . $row['firstName'] . " " . $row['lastName'] . " " . activ2eng($row['activ']) . "</button><br>";
        //TODO Fix this HTML?
    }
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
    }
}
