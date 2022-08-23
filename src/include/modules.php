<?php
function parseCsv(string $file)
{
    $csvAsArray = array_map('str_getcsv', file("/home/syntax/Downloads/exportUsers_2022-8-19.csv"));
    return $csvAsArray;
}
function getDomain()
{   
    $host = explode(":", $_SERVER['HTTP_HOST'])[0];
    return $host;
}
function sanatizeUser(array $userInfo)
{
    $userInfo[0] = preg_replace("/[^a-z.]+/i", "", $userInfo[0]);
    $userInfo[1] = preg_replace("/[^a-z.]+/i", "", $userInfo[1]);
    $userInfo[2] = preg_replace("/[^0-9.]+/i", "", $userInfo[2]);
    $userInfo[3] = filter_var($userInfo[3], FILTER_VALIDATE_EMAIL);
    return $userInfo;
}

function userExists($uname, $passwd, $db, $userKey) {
    $output = (sendSqlCommand("SELECT * FROM users WHERE sysID=" . $userKey, $uname, $passwd, $db));
    if ($output[0] == 1) {
        return false;
    }
    if (mysqli_num_rows($output[1]) != 0) {
        return true;
    } else {
        return false;
    }
}
function getUserData($uname, $passwd, $db, $key){
    $response = sendSqlCommand("SELECT * FROM users WHERE sysID=" . $key . ";", $uname, $passwd, $db)[1];
    $data = mysqli_fetch_array($response);
    return $data;
}
function roomExists($uname, $passwd, $db, $roomKey) {
    $output = (sendSqlCommand("SELECT * FROM rooms WHERE ID=" . $roomKey, $uname, $passwd, $db));
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
function adminCookieExists($uname, $passwd, $db, $cookie) {
    $output = (sendSqlCommand("SELECT * FROM adminCookie WHERE cookie=" . $cookie, $uname, $passwd, $db));
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
function teacherCookieExists($uname, $passwd, $db, $cookie) {
    $output = (sendSqlCommand("SELECT * FROM teacherCookie WHERE cookie=" . $cookie, $uname, $passwd, $db));
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
function getRoomData($uname, $passwd, $db, $key){
    $response = sendSqlCommand("SELECT * FROM rooms WHERE ID=" . $key, $uname, $passwd, $db)[1];
    $data = mysqli_fetch_array($response);
    return $data;
}
function sendSqlCommand($command, $uname, $passwd, $db)
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
function sendSqlCommandRaw($command, $uname, $passwd)
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
function installUser($info, $uname, $passwd, $db){
    $id = rand() . rand();
    $out = sendSqlCommand("INSERT users VALUES('" . $id . "', '" . $info[0] . "', '" . $info[1] . "', '" . $info[2] . "', '" . $info[3] . "', '1', '{\"rooms\": {}, \"cnum\": [0,0], \"activity\": {}}');", $uname, $passwd, $db);
    $out[2] = $id;
    return $out;

}
function installRoom($info, $uname, $passwd, $db){
    $id = $info['id'];
    $out = sendSqlCommand("INSERT rooms VALUES('" . $id . "', '" . $info['num'] . "');", $uname, $passwd, $db);
    $out[2] = $id;
    return $out;

}
function authAdmin($uname, $passwd, $db, $admUname, $admPasswd) {
    $out = sendSqlCommand("SELECT * FROM admins WHERE uname='" . $admUname . "';", $uname, $passwd, $db);
    if ($out[0] == 1) {
        return false;
    }
    $info = mysqli_fetch_array($out[1]);
    if ($info['passwd'] == $admPasswd) {
        return true;
    } else {
        return false;
    }
}
function authTeach($uname, $passwd, $db, $admUname, $admPasswd) {
    $out = sendSqlCommand("SELECT * FROM teachers WHERE uname='" . $admUname . "';", $uname, $passwd, $db);
    if ($out[0] == 1) {
        return false;
    }
    $info = mysqli_fetch_array($out[1]);
    if ($info['passwd'] == $admPasswd) {
        return true;
    } else {
        return false;
    }
}
function activ2eng($status) {
    if ($status == 1) {
        return "arrived";
    } else{
        return "departed";
    }
}