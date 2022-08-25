<?php

/** 
 * Room API
 * 
 * PHP version 8.1
 * 
 * @file     /src/api/room/index.php
 * @category API
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../../include/modules.php";
$config = parse_ini_file("../../../config/config.ini");


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

//Now we get to the real API
$request = unsetValue(explode("/", trim($_SERVER['REQUEST_URI'], "?key=" . $_GET['key'])), array("api", "room"));
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ((int) $level[1] == 0 or (int) $level[1] == 1) {
        // Level 0 and 1 API


        //
        userExistsErr("root", $config['sqlRootPasswd'], "VirtualPass", $level[2]);
        $user = getUserData("root", $config['sqlRootPasswd'], "VirtualPass", $level[2]);
        //if they are not requesting a specific room
        if (!isset($request[0])) {
            $miscData = json_decode($user['misc'], true);
            $output = array();
            foreach ($miscData['rooms'] as $roomID) {
                $output[$roomID] = getRoomData("root", $config['sqlRootPasswd'], "VirtualPass", $roomID)['num'];
            }
            echo json_encode($output);
            exit();
        } else { //If they do request a specific room
            $miscData = json_decode($user['misc'], true);
            $output = array();
            $output[preg_replace("/[^0-9.]+/i", "", $request[0])] = getRoomData("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $request[0]))['num'];
            echo json_encode($output);
            exit();
        }
        //


    } elseif ((int) $level[1] == 2 and (int) $level[1] == 3) {
        // Level 2 and 3 API

        //

        //

    }
}
if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    if ((int) $level[1] == 0) {
    } elseif ((int) $level[1] == 1) {
    } elseif ((int) $level[1] == 2) {
    } elseif ((int) $level[1] == 3) {
    }
}
if ($_SERVER['REQUEST_METHOD'] == "PATCH") {
    if ((int) $level[1] == 0) {
    } elseif ((int) $level[1] == 1) {
    } elseif ((int) $level[1] == 2) {
    } elseif ((int) $level[1] == 3) {
    }
}
if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    if ((int) $level[1] == 0) {
    } elseif ((int) $level[1] == 1) {
    } elseif ((int) $level[1] == 2) {
    } elseif ((int) $level[1] == 3) {
    }
}
