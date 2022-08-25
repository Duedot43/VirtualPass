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
$level = authApi("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['key']));
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
if ((int) $level[1] > 1) {
    echo json_encode(
        array(
            "success" => 0,
            "reason" => "high_level",
            "human_reason" => "Your level is too high to preform this action"
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
if (roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $request[0]))) {
    userExistsErr("root", $config['sqlRootPasswd'], "VirtualPass", $level[2]);
    $userData = getUserData("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $level[2]));
    $departureData = json_decode($userData['misc'], true);

    //Depart or arrive the user
    if ($userData['activ'] == 1) {
        $userData['activ'] = 0;
    } else {
        $userData['activ'] = 1;
    }
    //that's simple right?

    //register their room
    if (!in_array($request[0], $departureData['rooms'])) {
        array_push($departureData['rooms'], $request[0]);
    }

    $date = date("d") . "." . date("m") . "." . date("y");

    if (!isset($departureData['activity'][$date])) {
        $departureData['activity'][$date] = array();
        $departureData['cnum'] = array(0, 0);
    }

    //determin the time
    if ($departureData['cnum'][1] == 0) {
        $room = $request[0];
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
    sendSqlCommand(
        "UPDATE users 
    SET 
        activ = '" . $userData['activ'] . "'
    WHERE
        sysId=" . preg_replace("/[^0-9.]+/i", "", $level[2]) . ";",
        "root",
        $config['sqlRootPasswd'],
        "VirtualPass"
    );


    sendSqlCommand(
        "UPDATE users 
    SET 
        misc = '" . json_encode($departureData) . "'
    WHERE
        sysId=" . preg_replace("/[^0-9.]+/i", "", $level[2]) . ";",
        "root",
        $config['sqlRootPasswd'],
        "VirtualPass"
    );
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
