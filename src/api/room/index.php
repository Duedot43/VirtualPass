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
//Now we get to the real API
$request = unsetValue(explode("/", trim($_SERVER['REQUEST_URI'], "?key=" . $_GET['key'])), array("api", "room"));
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ((int) $level[1] == 0 or (int) $level[1] == 1) {
        // Level 0 and 1 API


        //
        userExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
        $user = getUserData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
        //if they are not requesting a specific room
        if (!isset($request[0])) {
            $miscData = json_decode($user['misc'], true);
            $output = array();
            foreach ($miscData['rooms'] as $roomID) {
                $output[$roomID] = getRoomData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $roomID)['num'];
            }
            echo json_encode($output);
            exit();
        } else { //If they do request a specific room
            $miscData = json_decode($user['misc'], true);
            $output = array();
            if (in_array($request[0], $miscData['rooms'])) {
                $output[preg_replace("/[^0-9.]+/i", "", $request[0])] = getRoomData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $request[0]))['num'];
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
            $result = sendSqlCommand("SELECT * FROM rooms;", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
            $output = array();
            while ($row = mysqli_fetch_assoc($result[1])) {
                $output[$row['ID']] = $row['num'];
            }
            echo json_encode($output);
            exit();
        } else { //do request a specific room
            roomExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $request[0]);
            $result = getRoomData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $request[0]));
            echo json_encode(array($result['ID']=>$result['num']));
            exit();
        }
        //

    }
}
//TODO PUT api/room
if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    if ((int) $level[1] == 0) {
        userExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
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
        userExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
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
        if (isset($request[0])) {
            $postJson = json_decode(file_get_contents("php://input"), true);
            if ($postJson == false or !isset($postJson['num']) and !isset($postJson['rnum'])) {
                echo json_encode(
                    array(
                        "success" => 0,
                        "reason" => "invalid_json",
                        "human_reason" => "The JSON you sent is invalid"
                    ),
                    true
                );
                err();
                exit();
            }
            // $request[0] is the room ID
            // $postJson['num'] is the room number
            // MY GOD GITHUB COPILOT IS GOOD
            $result = sendSqlCommand("INSERT rooms VALUES('" . preg_replace("/[^0-9.]+/i", "", $request[0]) . "', '" . preg_replace("/[^0-9.]+/i", "", $postJson['rnum']) . "');", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
            if ($result[0] == 0) {
                echo json_encode(
                    array(
                        "success" => 1,
                        "reason" => "",
                        "human_reason" => "Room number added"
                    ),
                    true
                );
                err();
                exit();
            } else {
                echo json_encode(
                    array(
                        "success" => 0,
                        "reason" => "sql_error",
                        "human_reason" => "An SQL error occurred"
                    ),
                    true
                );
                err();
                exit();
            }
        } else {
            echo json_encode(
                array(
                    "success" => 0,
                    "reason" => "id_required",
                    "human_reason" => "You must specify a room ID"
                ),
                true
            );
            err();
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "PATCH") {
    if ((int) $level[1] == 0) {
        userExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
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
        userExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
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
        if (isset($request[0])) {
            $postJson = json_decode(file_get_contents("php://input"), true);
            if ($postJson == false or !isset($postJson['num'])) {
                echo json_encode(
                    array(
                        "success" => 0,
                        "reason" => "invalid_json",
                        "human_reason" => "The JSON you sent is invalid"
                    ),
                    true
                );
                err();
                exit();
            }
            // $request[0] is the room ID
            // $postJson['num'] is the room number
            // MY GOD GITHUB COPILOT IS GOOD
            roomExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $request[0]));
            $result = sendSqlCommand("UPDATE rooms SET num = '" . preg_replace("/[^0-9.]+/i", "", $postJson['num']) . "' WHERE ID = '" . preg_replace("/[^0-9.]+/i", "", $request[0]) . "';", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
            if ($result[0] == 0) {
                echo json_encode(
                    array(
                        "success" => 1,
                        "reason" => "",
                        "human_reason" => "Room number updated"
                    ),
                    true
                );
                err();
                exit();
            } else {
                echo json_encode(
                    array(
                        "success" => 0,
                        "reason" => "sql_error",
                        "human_reason" => "An SQL error occurred"
                    ),
                    true
                );
                err();
                exit();
            }
        } else {
            $postJson = json_decode(file_get_contents("php://input"), true);
            if ($postJson == false or !isset($postJson['num'])) {
                echo json_encode(
                    array(
                        "success" => 0,
                        "reason" => "invalid_json",
                        "human_reason" => "The JSON you sent is invalid"
                    ),
                    true
                );
                err();
                exit();
            }
            $rooms = sendSqlCommand("SELECT * FROM rooms;", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
            while ($row = mysqli_fetch_array($rooms[1])) {
                $replace = sendSqlCommand("UPDATE rooms SET num = '" . preg_replace("/[^0-9.]+/i", "", $postJson['num']) . "' WHERE ID = '" . $row['ID'] . "';", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
                if ($replace[0] == 1) {
                    echo json_encode(
                        array(
                            "success" => 0,
                            "reason" => "sql_error",
                            "human_reason" => "An SQL error occurred"
                        ),
                        true
                    );
                    err();
                    exit();
                }
            }
            echo json_encode(
                array(
                    "success" => 1,
                    "reason" => "",
                    "human_reason" => "Room numbers updated"
                ),
                true
            );
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    if ((int) $level[1] == 0) {
        userExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
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
        userExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
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
        userExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
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
        if (isset($request[0])) {
            roomExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $request[0]));
            $result = sendSqlCommand("DELETE FROM rooms WHERE ID = '" . preg_replace("/[^0-9.]+/i", "", $request[0]) . "';", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
            if ($result[0] == 0) {
                echo json_encode(
                    array(
                        "success" => 1,
                        "reason" => "",
                        "human_reason" => "Room deleted"
                    ),
                    true
                );
                err();
                exit();
            } else {
                echo json_encode(
                    array(
                        "success" => 0,
                        "reason" => "sql_error",
                        "human_reason" => "An SQL error occurred"
                    ),
                    true
                );
                err();
                exit();
            }
        } else {
            $rooms = sendSqlCommand("SELECT * FROM rooms;", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
            while ($row = mysqli_fetch_array($rooms[1])) {
                $replace = sendSqlCommand("DELETE FROM rooms WHERE ID = '" . $row['ID'] . "';", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
                if ($replace[0] == 1) {
                    echo json_encode(
                        array(
                            "success" => 0,
                            "reason" => "sql_error",
                            "human_reason" => "An SQL error occurred"
                        ),
                        true
                    );
                    err();
                    exit();
                }
            }
            echo json_encode(
                array(
                    "success" => 1,
                    "reason" => "",
                    "human_reason" => "Rooms deleted"
                ),
                true
            );
        }
    }
}
