<?php

/** 
 * Departure API
 * 
 * PHP version 8.1
 * 
 * @file     /src/api/room/toggle/index.php
 * @category API
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../../../include/modules.php";
$config = parse_ini_file("../../../../config/config.ini");
$domain = getDomain();

if (!isset($_GET['key'])) {
    echo json_encode(
        array(
            "success" => 0,
            "reason" => "key_not_set",
            "human_reason" => "API key is not set"
        ),
        true
    );
    err();
    exit();
}
$level = authApi($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['key']));
if (!$level[0]) {
    echo json_encode(
        array(
            "success" => 0,
            "reason" => "invalid_key",
            "human_reason" => "Your API key is not valid"
        ),
        true
    );
    authFail();
    exit();
}
// See if they made too many requests
tooMuchReqErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['key']));
if ((int) $level[1] > 1) {
    echo json_encode(
        array(
            "success" => 0,
            "reason" => "high_level",
            "human_reason" => "Your level is too high to preform this action (aka you are too superiour)"
        ),
        true
    );
    err();
    exit();
}
//Now we get to the real API
$request = unsetValue(explode("/", trim($_SERVER['REQUEST_URI'], "?key=" . $_GET['key'])), array("api", "room", "toggle"));
if (!isset($request[0])) {
    echo json_encode(
        array(
            "success" => 0,
            "reason" => "no_room",
            "human_reason" => "You do not have a room number to depart/arrive from"
        ),
        true
    );
    err();
    exit();
}
if (roomExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $request[0]))) {
    userExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
    $userData = getUserData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $level[2]));
    $departureData = json_decode($userData['misc'], true);
    if (!in_array($request[0], $departureData['rooms'])) {
        echo json_encode(
            array(
                "success" => 0,
                "reason" => "invalid_room",
                "human_reason" => "The room you requested does not exist"
            ),
            true
        );
        err();
        exit();
    }

    //register their room

    $date = date("d") . "." . date("m") . "." . date("y");

    if (!isset($departureData['activity'][$date])) {
        $departureData['activity'][$date] = array();
        $departureData['cnum'] = array(0, 0);
        $departureData['activity'][$date][$departureData['cnum'][0]] = array(
            "room" => "",
            "timeDep" => "",
            "timeArv" => ""
        );
    }

    //determin the time
    if ((int) $userData['activ'] == 1) {
        $room = preg_replace("/[^0-9.]+/i", "", $request[0]);
        $timeDep = time();
        $timeArv = "";
        $departureData['cnum'][1] = 1;
        $set = false;
    } else {
        //TODO bug over multipul days when the user is departed over days
        $room = $departureData['activity'][$date][$departureData['cnum'][0]]['room'];
        $timeDep = $departureData['activity'][$date][$departureData['cnum'][0]]['timeDep'];
        $timeArv = time();
        $departureData['cnum'][1] = 0;
        $set = true;
        $departureData['activity'][$date][$departureData['cnum'][0] + 1] = array(
            "room" => "",
            "timeDep" => "",
            "timeArv" => ""
        );
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
    sysId=" . preg_replace("/[^0-9.]+/i", "", $level[2]) . ";",
        $config['sqlUname'],
        $config['sqlPasswd'],
        $config['sqlDB']
    );


    sendSqlCommand(
        "UPDATE users 
SET 
    misc = '" . json_encode($departureData) . "'
WHERE
    sysId=" . preg_replace("/[^0-9.]+/i", "", $level[2]) . ";",
        $config['sqlUname'],
        $config['sqlPasswd'],
        $config['sqlDB']
    );
    snapshot($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $config['snapshotTime']);
    echo json_encode(
        array(
            "success" => 1,
            "reason" => "success",
            "human_reason" => "success",
            "status" => $userData['activ']
        ),
        true
    );
    exit();
} else {
    echo json_encode(
        array(
            "success" => 0,
            "reason" => "invalid_room",
            "human_reason" => "The room you requested does not exist"
        ),
        true
    );
    err();
    exit();
}
