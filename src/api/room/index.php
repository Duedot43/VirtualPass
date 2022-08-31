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
            if (in_array($request[0], $miscData['rooms'])) {
                $output[preg_replace("/[^0-9.]+/i", "", $request[0])] = getRoomData("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $request[0]))['num'];
                echo json_encode($output);
                exit();
            } else {
                echo json_encode(
                    array(
                        "success" => 0,
                        "reason" => "invalid_room_id",
                        "human_reason" => "The room ID you requested is not assigned to you"
                    ),
                    true
                );
                err();
                exit();
            }
        }
        //


    } elseif ((int) $level[1] == 2 or (int) $level[1] == 3) {
        // Level 2 and 3 API

        //
        if (!isset($request[0])) { //they do not request a specific room
            $result = sendSqlCommand("SELECT * FROM rooms;", "root", $config['sqlRootPasswd'], "VirtualPass");
            $output = array();
            while ($row = mysqli_fetch_assoc($result[1])) {
                $output[$row['ID']] = $row['num'];
            }
            echo json_encode($output);
            exit();
        } else { //do request a specific room
            roomExistsErr("root", $config['sqlRootPasswd'], "VirtualPass", $request[0]);
            $result = getRoomData("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $request[0]));
            echo json_encode(array($result['ID']=>$result['num']));
            exit();
        }
        //

    }
}
if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    if ((int) $level[1] == 0) {
        userExistsErr("root", $config['sqlRootPasswd'], "VirtualPass", $level[2]);
        echo json_encode(
            array(
                "success" => 0,
                "reason" => "no_access",
                "human_reason" => "You do not have access to this method"
            ),
            true
        );
        authFail();
        exit();
    } elseif ((int) $level[1] == 1) {
        userExistsErr("root", $config['sqlRootPasswd'], "VirtualPass", $level[2]);
        echo json_encode(
            array(
                "success" => 0,
                "reason" => "no_access",
                "human_reason" => "You do not have access to this method"
            ),
            true
        );
        authFail();
        exit();
    } elseif ((int) $level[1] == 2) {
        echo json_encode(
            array(
                "success" => 0,
                "reason" => "no_access",
                "human_reason" => "You do not have access to this method"
            ),
            true
        );
        err();
        exit();
    } elseif ((int) $level[1] == 3) {
        //TODO Level 3 room api PUT
    }
}
if ($_SERVER['REQUEST_METHOD'] == "PATCH") {
    if ((int) $level[1] == 0) {
        userExistsErr("root", $config['sqlRootPasswd'], "VirtualPass", $level[2]);
        echo json_encode(
            array(
                "success" => 0,
                "reason" => "no_access",
                "human_reason" => "You do not have access to this method"
            ),
            true
        );
        authFail();
        exit();
    } elseif ((int) $level[1] == 1) {
        userExistsErr("root", $config['sqlRootPasswd'], "VirtualPass", $level[2]);
        echo json_encode(
            array(
                "success" => 0,
                "reason" => "no_access",
                "human_reason" => "You do not have access to this method"
            ),
            true
        );
        authFail();
        exit();
    } elseif ((int) $level[1] == 2) {
        userExistsErr("root", $config['sqlRootPasswd'], "VirtualPass", $level[2]);
        echo json_encode(
            array(
                "success" => 0,
                "reason" => "no_access",
                "human_reason" => "You do not have access to this method"
            ),
            true
        );
        authFail();
        exit();
    } elseif ((int) $level[1] == 3) {
        //TODO level 3 room api PATCH
    }
}
if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    if ((int) $level[1] == 0) {
        userExistsErr("root", $config['sqlRootPasswd'], "VirtualPass", $level[2]);
        echo json_encode(
            array(
                "success" => 0,
                "reason" => "no_access",
                "human_reason" => "You do not have access to this method"
            ),
            true
        );
        authFail();
        exit();
    } elseif ((int) $level[1] == 1) {
        userExistsErr("root", $config['sqlRootPasswd'], "VirtualPass", $level[2]);
        echo json_encode(
            array(
                "success" => 0,
                "reason" => "no_access",
                "human_reason" => "You do not have access to this method"
            ),
            true
        );
        authFail();
        exit();
    } elseif ((int) $level[1] == 2) {
        userExistsErr("root", $config['sqlRootPasswd'], "VirtualPass", $level[2]);
        echo json_encode(
            array(
                "success" => 0,
                "reason" => "no_access",
                "human_reason" => "You do not have access to this method"
            ),
            true
        );
        authFail();
        exit();
    } elseif ((int) $level[1] == 3) {
        //TODO level 3 room api DELETE
    }
}
