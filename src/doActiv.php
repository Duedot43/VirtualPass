<?php

/** 
 * Departs or arrives the user
 * 
 * PHP version 8.1
 * 
 * @file     /src/doActiv.php
 * @category Activity_Changer
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "include/modules.php";
$domain = getDomain();
if (!isset($_GET['room'])) {
    header('Location: /');
    exit();
}
$config = parse_ini_file("../config/config.ini");
if (isset($_COOKIE['id']) and userExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^a-zA-Z0-9]/", "", $_COOKIE['id'])) and roomExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {

    $userData = getUserData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']));
    $departureData = json_decode($userData['misc'], true);


    //register their room
    if (!in_array($_GET['room'], $departureData['rooms'])) {
        $departureData['rooms'][] = $_GET['room'];
    }

    $date = date("d") . "." . date("m") . "." . date("y");
    $skip = false;
    if (!isset($departureData['activity'][$date])) {
        $departureData['dates'][] = $date;
        $departureData['activity'][$date] = array();
        // Wow that is some DEEPLY nested stuff right there
        if ((int) $userData['activ'] == 0 and count($departureData['dates']) > 1 and $departureData['activity'][$departureData['dates'][count($departureData['dates']) - 2]][$departureData['cnum'][0]]['timeArv'] == "") {
            $departureData['activity'][$departureData['dates'][count($departureData['dates']) - 2]][$departureData['cnum'][0]]['timeArv'] = time();
            $skip = true;
        }
        $departureData['cnum'] = array(0, 0);

    }
    if (!$skip) {
        //determin the time
        if ((int) $userData['activ'] == 1) {
            $room = preg_replace("/[^0-9.]+/i", "", $_GET['room']);
            $timeDep = time();
            $timeArv = "";
            $departureData['cnum'][1] = 1;
            $set = false;
        } else {
            $room = $departureData['activity'][$date][$departureData['cnum'][0]]['room'];
            $timeDep = $departureData['activity'][$date][$departureData['cnum'][0]]['timeDep'];
            $timeArv = time();
            $departureData['cnum'][1] = 0;
            $set = true;
        }

        //mark down the time that the user does an activity
        $departureData['activity'][$date][$departureData['cnum'][0]] = array(
            "room" => $room,
            "timeDep" => $timeDep,
            "timeArv" => $timeArv
        );
        if ($set) {
            $departureData['cnum'][0] = $departureData['cnum'][0] + 1;
        }
    }

    //Depart or arrive the user
    if ((int) $userData['activ'] === 1) {
        $userData['activ'] = 0;
    } else {
        $userData['activ'] = 1;
    }
    //that's simple right?

    sendSqlCommand(
        "UPDATE users 
    SET 
        activ = '" . $userData['activ'] . "'
    WHERE
        sysId=" . preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']) . ";",
        $config['sqlUname'],
        $config['sqlPasswd'],
        $config['sqlDB']
    );


    sendSqlCommand(
        "UPDATE users 
    SET 
        misc = '" . json_encode($departureData) . "'
    WHERE
        sysId=" . preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']) . ";",
        $config['sqlUname'],
        $config['sqlPasswd'],
        $config['sqlDB']
    );
    snapshot($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $config['snapshotTime']);
    header("Location: /?room=" . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
} else {
    header("Location: /login.php?room=" . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
}
