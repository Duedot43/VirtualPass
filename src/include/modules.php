<?php

/** 
 * The main modules file
 * 
 * PHP version 8.1
 * 
 * @file     /src/include/modules.php
 * @category General_Functions
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */

// HELP ME THIS CODE SNIFFER EXTENTION IS MAKING ME SUFFER

/**
 * Parse a CSV file
 *
 * @param string $file Is the CSV file you want to parse into an array
 * 
 * @return array returns the CSV file as an array
 */
function parseCsv(string $file)
{
    $csvAsArray = array_map(
        'str_getcsv',
        file("/home/syntax/Downloads/exportUsers_2022-8-19.csv")
    );
    return $csvAsArray;
}
/**
 * Get the domain name
 *
 * @return string
 */
function getDomain()
{
    $host = explode(":", $_SERVER['HTTP_HOST'])[0];
    return $host;
}
/**
 * Sanatize user info
 *
 * @param array $userInfo User info to be sanatized
 * 
 * @return array
 */
function sanatizeUser(array $userInfo)
{
    $userInfo[0] = preg_replace("/[^a-z.]+/i", "", $userInfo[0]);
    $userInfo[1] = preg_replace("/[^a-z.]+/i", "", $userInfo[1]);
    $userInfo[2] = preg_replace("/[^0-9.]+/i", "", $userInfo[2]);
    $userInfo[3] = filter_var($userInfo[3], FILTER_VALIDATE_EMAIL);
    return $userInfo;
}
/**
 * User Exists
 *
 * @param string $uname   The MySQL username
 * @param string $passwd  The MySQL pasword
 * @param string $db      The MySQL database name
 * @param string $userKey The user unique ID
 * 
 * @return bool
 */
function userExists(string $uname, string $passwd, string $db, string $userKey)
{
    $output = sendSqlCommand(
        "SELECT * FROM users WHERE sysID=" . $userKey,
        $uname,
        $passwd,
        $db
    );
    if ($output[0] == 1) {
        return false;
    }
    if (mysqli_num_rows($output[1]) != 0) {
        return true;
    } else {
        return false;
    }
}
/**
 * Get User Data
 *
 * @param string $uname  The MySQL username
 * @param string $passwd The MySQL pasword
 * @param string $db     The MySQL database name
 * @param string $key    The user unique ID
 * 
 * @return void
 */
function getUserData(string $uname, string $passwd, string $db, string $key)
{
    $response = sendSqlCommand(
        "SELECT * FROM users WHERE sysID=" . $key . ";",
        $uname,
        $passwd,
        $db
    )[1];
    $data = mysqli_fetch_array($response);
    return $data;
}
/**
 * Room Exists
 *
 * @param string $uname   The MySQL username
 * @param string $passwd  The MySQL pasword
 * @param string $db      The MySQL database name
 * @param string $roomKey The room ID 
 * 
 * @return bool
 */
function roomExists(string $uname, string $passwd, string $db, string $roomKey)
{
    $output = sendSqlCommand(
        "SELECT * FROM rooms WHERE ID=" . $roomKey,
        $uname,
        $passwd,
        $db
    );
    if ($output[0] == 1) {
        return false;
    }
    //????
    if (mysqli_num_rows($output[1]) != 0) {
        return true;
    } else {
        return false;
    }
}
/**
 * Admin Cookie Exists
 *
 * @param string $uname  The MySQL username
 * @param string $passwd The MySQL pasword
 * @param string $db     The MySQL database name
 * @param string $cookie The admin cookie
 * 
 * @return bool
 */
function adminCookieExists(string $uname, string $passwd, string $db, string $cookie)
{
    $output = sendSqlCommand(
        "SELECT * FROM admins",
        $uname,
        $passwd,
        $db
    );
    if ($output[0] == 1) {
        return false;
    }
    //????
    while ($row = mysqli_fetch_assoc($output[1])) {
        if ($row['uuid'] == $cookie) {
            return true;
        }
    }
    return false;
}
/**
 * Teacher Cookie Exists
 *
 * @param string $uname  The MySQL username
 * @param string $passwd The MySQL pasword
 * @param string $db     The MySQL database name
 * @param string $cookie The teacher cookie
 * 
 * @return bool
 */
function teacherCookieExists(
    string $uname,
    string $passwd,
    string $db,
    string $cookie
) {
    $output = sendSqlCommand(
        "SELECT * FROM teachers",
        $uname,
        $passwd,
        $db
    );
    if ($output[0] == 1) {
        return false;
    }
    //????
    while ($row = mysqli_fetch_assoc($output[1])) {
        if ($row['uuid'] == $cookie) {
            return true;
        }
    }
    return false;
}
/**
 * Get Room Data
 *
 * @param string $uname  The MySQL username
 * @param string $passwd The MySQL pasword
 * @param string $db     The MySQL database name
 * @param string $key    The room ID
 * 
 * @return array
 */
function getRoomData(string $uname, string $passwd, string $db, string $key)
{
    $response = sendSqlCommand(
        "SELECT * FROM rooms WHERE ID=" . $key,
        $uname,
        $passwd,
        $db
    )[1];
    $data = mysqli_fetch_array($response);
    return $data;
}
/**
 * Send an SQL command
 *
 * @param string $command The SQL command to be executed
 * @param string $uname   The MySQL username
 * @param string $passwd  The MySQL pasword
 * @param string $db      The MySQL database name
 * 
 * @return array
 */
function sendSqlCommand(string $command, string $uname, string $passwd, string $db)
{
    $srvName = "localhost";
    try {
        $conn = new mysqli($srvName, $uname, $passwd, $db);
        $result = $conn->query($command);
    } catch (Exception $error) {
        return [1, $error->getMessage()];
    }
    $conn->close();
    return [0, $result];
}
/**
 * Send SQL Command Raw
 *
 * @param string $command The command to be issueds
 * @param string $uname   The MySQL username
 * @param string $passwd  The MySQL pasword
 * 
 * @return array
 */
function sendSqlCommandRaw(string $command, string $uname, string $passwd)
{
    $srvName = "localhost";

    try {
        $conn = new mysqli($srvName, $uname, $passwd);
        $result = $conn->query($command);
    } catch (Exception $error) {
        return [1, $error->getMessage()];
    }
    $conn->close();
    return [0, $result];
}
/**
 * Install User
 *
 * @param array  $info   User info with 0 being firstName 1 being lastName
 *                       2 being ID 3 being email
 * @param string $uname  The MySQL username
 * @param string $passwd The MySQL pasword
 * @param string $db     The MySQL database name
 * 
 * @return array
 */
function installUser(array $info, string $uname, string $passwd, string $db)
{
    $id = rand() . rand();
    $out = sendSqlCommand(
        "INSERT users VALUES(
            '" . $id . "', 
            '" . $info[0] . "', 
            '" . $info[1] . "', 
            '" . $info[2] . "', 
            '" . $info[3] . "', 
            '1', 
            '{\"rooms\": {}, \"cnum\": [0,0], \"activity\": {}}'
        );",
        $uname,
        $passwd,
        $db
    );
    $out = sendSqlCommand(
        "INSERT apiKeys VALUES(
            '" . rand() . rand() . "',
            '0',
            '" . $id . "'
        );",
        $uname,
        $passwd,
        $db
    );
    $out[2] = $id;
    return $out;
}
/**
 * Install Room
 *
 * @param array  $info   The room info with 'id' being the ID of the room 
 *                       and 'num' being the room number
 * @param string $uname  The MySQL username
 * @param string $passwd The MySQL pasword
 * @param string $db     The MySQL database name
 * 
 * @return array
 */
function installRoom(array $info, string $uname, string $passwd, string $db)
{
    $id = $info['id'];
    $out = sendSqlCommand(
        "INSERT rooms VALUES('" . $id . "', '" . $info['num'] . "');",
        $uname,
        $passwd,
        $db
    );
    $out[2] = $id;
    return $out;
}
/**
 * Admin Authentication
 *
 * @param string $uname     The MySQL username
 * @param string $passwd    The MySQL pasword
 * @param string $db        The MySQL database name
 * @param string $admUname  The user inputed admin username
 * @param string $admPasswd The user inputed admin password
 * 
 * @return array
 */
function authAdmin(
    string $uname,
    string $passwd,
    string $db,
    string $admUname,
    string $admPasswd
) {
    $out = sendSqlCommand(
        "SELECT * FROM admins WHERE uname='" . $admUname . "';",
        $uname,
        $passwd,
        $db
    );
    if ($out[0] == 1) {
        return array(false);
    }
    $info = mysqli_fetch_array($out[1]);
    if (!isset($info['passwd'])) {
        return array(false);
    }
    if ($info['passwd'] == $admPasswd) {
        return array(true, $info['uuid']);
    } else {
        return array(false);
    }
}
/**
 * Teacher Authentication
 *
 * @param string $uname       The MySQL username
 * @param string $passwd      The MySQL pasword
 * @param string $db          The MySQL database name
 * @param string $teachUname  The user inputed teacher username
 * @param string $teachPasswd The user inputed teacher password
 * 
 * @return array
 */
function authTeach(
    string $uname,
    string $passwd,
    string $db,
    string $teachUname,
    string $teachPasswd
) {
    $out = sendSqlCommand(
        "SELECT * FROM teachers WHERE uname='" . $teachUname . "';",
        $uname,
        $passwd,
        $db
    );
    if ($out[0] == 1) {
        return array(false);
    }
    $info = mysqli_fetch_array($out[1]);
    if (!isset($info['passwd'])) {
        return array(false);
    }
    if ($info['passwd'] == $teachPasswd) {
        return array(true, $info['uuid']);
    } else {
        return array(false);
    }
}
/**
 * API Auth
 *
 * @param string $uname  The MySQL username
 * @param string $passwd The MySQL pasword
 * @param string $db     The MySQL database name
 * @param string $key    The API key
 * 
 * @return array
 */
function authApi(
    string $uname,
    string $passwd,
    string $db,
    string $key,
) {
    $out = sendSqlCommand(
        "SELECT * FROM apiKeys WHERE apiKey='" . $key . "';",
        $uname,
        $passwd,
        $db
    );
    if ($out[0] == 1) {
        return array(false);
    }
    $info = mysqli_fetch_array($out[1]);
    if (!isset($info['apiKey'])) {
        return array(false);
    } else {
        return array(true, $info['perms'], $info['user']);
    }
}
/**
 * Activity to English
 *
 * @param int $status The user status can be 1 or 0
 * 
 * @return string
 */
function activ2eng(int $status)
{
    if ($status == 1) {
        return "arrived";
    } else {
        return "departed";
    }
}
/**
 * Unset a value in a URL
 *
 * @param array   $array  Array to be parsed
 * @param array   $value  Things to be removed from array
 * @param boolean $strict If strict or not
 * 
 * @return array
 */
function unsetValue(array $array, array $value, $strict = true)
{
    foreach ($value as $val) {
        if (($key = array_search($val, $array, $strict)) !== false) {
            unset($array[$key]);
        }
    }
    $count = -1;
    $new_arr = array();
    foreach ($array as $arr_val) {
        if ($arr_val == "") {
            unset($array[$count]);
        } else {
            $new_arr[$count] = $arr_val;
        }
        $count = $count + 1;
    }
    return $new_arr;
}
/**
 * Auth fail
 *
 * @return void
 */
function authFail()
{
    header('WWW-Authenticate: Basic realm="api"');
    header('HTTP/1.0 401 Unauthorized');
}
/**
 * Error
 *
 * @return void
 */
function err()
{
    header('HTTP/1.0 406 Not Acceptable');
}
/**
 * Errors if the user does not exist for the API
 *
 * @param string $uname  The MySQL username
 * @param string $passwd The MySQL pasword
 * @param string $db     The MySQL database name
 * @param string $user   The user ID
 * 
 * @return void
 */
function userExistsErr(string $uname, string $passwd, string $db, string $user)
{
    if (!userExists($uname, $passwd, $db, $user)) {
        echo json_encode(
            array(
                "success" => 0,
                "reason" => "corrupt_key",
                "human_reason" => "The user listed in your API key does not exist please contact a system administrator"
            ),
            true
        );
        err();
        exit();
    }
}
/**
 * Errors if the room does not exist for the API
 *
 * @param string $uname  The MySQL username
 * @param string $passwd The MySQL pasword
 * @param string $db     The MySQL database name
 * @param string $room   The user ID
 * 
 * @return void
 */
function roomExistsErr(string $uname, string $passwd, string $db, string $room)
{
    if (!roomExists($uname, $passwd, $db, $room)) {
        echo json_encode(
            array(
                "success" => 0,
                "reason" => "invalid_room",
                "human_reason" => "That room does not exist"
            ),
            true
        );
        err();
        exit();
    }
}
/**
 * Get admin by uuid
 *
 * @param string $uname  The MySQL username
 * @param string $passwd The MySQL pasword
 * @param string $db     The MySQL database name
 * @param string $uuid   The admins uuid
 * 
 * @return array
 */
function getAdminByUuid(string $uname, string $passwd, string $db, string $uuid)
{
    $output = sendSqlCommand(
        "SELECT * FROM admins",
        $uname,
        $passwd,
        $db
    );
    //????
    while ($row = mysqli_fetch_assoc($output[1])) {
        if ($row['uuid'] == $uuid) {
            return $row;
        }
    }
    return array(null);
}

/**
 * Get teacher by uuid
 *
 * @param string $uname  The MySQL username
 * @param string $passwd The MySQL pasword
 * @param string $db     The MySQL database name
 * @param string $uuid   The teacher uuid
 * 
 * @return array
 */
function getTeacherByUuid(string $uname, string $passwd, string $db, string $uuid)
{
    $output = sendSqlCommand(
        "SELECT * FROM teachers",
        $uname,
        $passwd,
        $db
    );
    //????
    while ($row = mysqli_fetch_assoc($output[1])) {
        if ($row['uuid'] == $uuid) {
            return $row;
        }
    }
    return array(null);
}
