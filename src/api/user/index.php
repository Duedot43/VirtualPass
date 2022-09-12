<?php

/** 
 * User API
 * 
 * PHP version 8.1
 * 
 * @file     /src/api/user/index.php
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
//Now we get to the real api
$request = unsetValue(explode("/", $_SERVER['REQUEST_URI']), array("api", "user"));
// If the user requests a user with a GET request
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if ((int) $level[1] == 0 or (int) $level[1] == 1) {
        //level 0 and 1 API

        //
        userExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
        $user = getUserData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
        $output = array(
            "sysID" => $user['sysID'],
            "firstName" => $user['firstName'],
            "lastName" => $user['lastName'],
            "ID" => $user['ID'],
            "email" => $user['email'],
            "misc" => json_decode($user['misc'])
        );
        echo json_encode($output);
        exit();
        //

    } elseif ((int) $level[1] == 2 or (int) $level[1] == 3) {
        // Level 2 and 3 API

        //
        //cycle through all the users and display them
        $result = sendSqlCommand("SELECT * FROM users;", "root", $config['sqlPasswd'], "VirtualPass");
        $output = array();
        while ($row = mysqli_fetch_assoc($result[1])) {
            $output[$row['sysID']] = array(
                "sysID" => $row['sysID'],
                "firstName" => $row['firstName'],
                "lastName" => $row['lastName'],
                "ID" => $row['ID'],
                "email" => $row['email'],
                "misc" => json_decode($row['misc'])
            );
        }
        echo json_encode($output);
        exit();
        //

    }
}
if ($_SERVER['REQUEST_METHOD'] == "PUT" or $_SERVER['REQUEST_METHOD'] == "PATCH") {
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
        // See if the user exists
        userExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $level[2]);
        $postJson = json_decode(file_get_contents("php://input"), true);
        if ($postJson == false or !isset($postJson['firstName']) or !isset($postJson['lastName']) or !isset($postJson['ID']) or !isset($postJson['email'])) {
            echo json_encode(
                array(
                    "success" => 0,
                    "reason" => "invalid_json",
                    "human_reason" => "The JSON you sent is invalid"
                ),
                true
            );
            exit();
        }

        // Sanatize the data
        $sanUser = sanatizeUser(array($postJson['firstName'], $postJson['lastName'], $postJson['ID'], $postJson['email']));
        if ($sanUser[3] == false) {
            echo json_encode(
                array(
                    "success" => 0,
                    "reason" => "invalid_email",
                    "human_reason" => "The email you sent is invalid"
                ),
                true
            );
            err();
            exit();
        }

        $user = array(
            "firstName" => $sanUser[0],
            "lastName" => $sanUser[1],
            "ID" => $sanUser[2],
            "email" => $postJson['email']
        );
        $result = sendSqlCommand(
            "UPDATE users SET firstName = '" . $user['firstName'] . "', lastName = '" . $user['lastName'] . "', ID = '" . $user['ID'] . "', email = '" . $user['email'] . "' WHERE sysID = '" . $level[2] . "';",
            "root",
            $config['sqlPasswd'],
            "VirtualPass"
        );
        if ($result[0] == 0) {
            echo json_encode(
                array(
                    "success" => 1,
                    "reason" => "user_updated",
                    "human_reason" => "Your user info was updated"
                ),
                true
            );
            exit();
        } else {
            echo json_encode(
                array(
                    "success" => 0,
                    "reason" => "sql_error",
                    "human_reason" => "There was an error updating your user info"
                ),
                true
            );
            err();
            exit();
        }
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
            if (userExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9]/", "", $request[0]))) {
                $postJson = json_decode(file_get_contents("php://input"), true);
                if ($postJson == false or !isset($postJson['firstName']) or !isset($postJson['lastName']) or !isset($postJson['ID']) or !isset($postJson['email'])) {
                    echo json_encode(
                        array(
                            "success" => 0,
                            "reason" => "invalid_json",
                            "human_reason" => "The JSON you sent is invalid"
                        ),
                        true
                    );
                    exit();
                }

                // Sanatize the data
                $sanUser = sanatizeUser(array($postJson['firstName'], $postJson['lastName'], $postJson['ID'], $postJson['email']));
                if ($sanUser[3] == false) {
                    echo json_encode(
                        array(
                            "success" => 0,
                            "reason" => "invalid_email",
                            "human_reason" => "The email you sent is invalid"
                        ),
                        true
                    );
                    err();
                    exit();
                }

                $user = array(
                    "firstName" => $sanUser[0],
                    "lastName" => $sanUser[1],
                    "ID" => $sanUser[2],
                    "email" => $postJson['email']
                );
                $result = sendSqlCommand(
                    "UPDATE users SET firstName = '" . $user['firstName'] . "', lastName = '" . $user['lastName'] . "', ID = '" . $user['ID'] . "', email = '" . $user['email'] . "' WHERE sysID = '" . $request[0] . "';",
                    "root",
                    $config['sqlPasswd'],
                    "VirtualPass"
                );
                if ($result[0] == 0) {
                    echo json_encode(
                        array(
                            "success" => 1,
                            "reason" => "user_updated",
                            "human_reason" => "Your user info was updated"
                        ),
                        true
                    );
                    exit();
                } else {
                    echo json_encode(
                        array(
                            "success" => 0,
                            "reason" => "sql_error",
                            "human_reason" => "There was an error updating your user info"
                        ),
                        true
                    );
                    err();
                }
            }
        } else {
            // If they want all users changed
            $postJson = json_decode(file_get_contents("php://input"), true);
            if ($postJson == false or !isset($postJson['firstName']) or !isset($postJson['lastName']) or !isset($postJson['ID']) or !isset($postJson['email'])) {
                echo json_encode(
                    array(
                        "success" => 0,
                        "reason" => "invalid_json",
                        "human_reason" => "The JSON you sent is invalid"
                    ),
                    true
                );
                exit();
            }

            // Sanatize the data
            $sanUser = sanatizeUser(array($postJson['firstName'], $postJson['lastName'], $postJson['ID'], $postJson['email']));
            if ($sanUser[3] == false) {
                echo json_encode(
                    array(
                        "success" => 0,
                        "reason" => "invalid_email",
                        "human_reason" => "The email you sent is invalid"
                    ),
                    true
                );
                err();
                exit();
            }

            $user = array(
                "firstName" => $sanUser[0],
                "lastName" => $sanUser[1],
                "ID" => $sanUser[2],
                "email" => $postJson['email']
            );
            $users = sendSqlCommand(
                "SELECT * FROM users;",
                "root",
                $config['sqlPasswd'],
                "VirtualPass"
            );
            while ($row = mysqli_fetch_array($users[1])) {
                $userSet = sendSqlCommand("UPDATE users SET firstName = '" . $user['firstName'] . "', lastName = '" . $user['lastName'] . "', ID = '" . $user['ID'] . "', email = '" . $user['email'] . "' WHERE sysID = '" . $row['sysID'] . "';", "root", $config['sqlPasswd'], "VirtualPass");
                if ($userSet[0] != 0) {
                    echo json_encode(
                        array(
                            "success" => 0,
                            "reason" => "sql_error",
                            "human_reason" => "There was an error updating your user info"
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
                    "reason" => "users_updated",
                    "human_reason" => "All users updated"
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
            // If they want a specific user deleted
            userExistsErr($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $request[0]);
            $result = sendSqlCommand(
                "DELETE FROM users WHERE sysID = '" . preg_replace("/[^0-9]/", "", $request[0]) . "';",
                "root",
                $config['sqlPasswd'],
                "VirtualPass"
            );
            if ($result[0] == 0) {
                echo json_encode(
                    array(
                        "success" => 1,
                        "reason" => "user_deleted",
                        "human_reason" => "Your user was deleted"
                    ),
                    true
                );
                exit();
            } else {
                echo json_encode(
                    array(
                        "success" => 0,
                        "reason" => "sql_error",
                        "human_reason" => "There was an error deleting your user"
                    ),
                    true
                );
                err();
            }
        } else {
            // If they want all users deleted
            $users = sendSqlCommand(
                "SELECT * FROM users;",
                "root",
                $config['sqlPasswd'],
                "VirtualPass"
            );
            while ($row = mysqli_fetch_array($users[1])) {
                $userSet = sendSqlCommand("DELETE FROM users WHERE sysID = '" . $row['sysID'] . "';", "root", $config['sqlPasswd'], "VirtualPass");
                if ($userSet[0] != 0) {
                    echo json_encode(
                        array(
                            "success" => 0,
                            "reason" => "sql_error",
                            "human_reason" => "There was an error deleting your user"
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
                    "reason" => "users_deleted",
                    "human_reason" => "All users deleted"
                ),
                true
            );
        }
    }
}
