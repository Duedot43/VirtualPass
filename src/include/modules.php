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
    $output = mysqli_fetch_array(sendSqlCommand("SELECT * FROM users WHERE sysID=" . $userKey, $uname, $passwd, $db)[1]);
    if (is_array($output)) {
        return true;
    } else {
        return false;
    }
}
function getUserData($uname, $passwd, $db, $key){
    $response = sendSqlCommand("SELECT * FROM users WHERE sysID=" . $key, $uname, $passwd, $db)[1];
    $data = mysqli_fetch_array($response);
    return $data;
}
function roomExists($uname, $passwd, $db, $roomKey) {
    $output = mysqli_fetch_array(sendSqlCommand("SELECT * FROM rooms WHERE ID=" . $roomKey, $uname, $passwd, $db)[1]);
    if (is_array($output)) {
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
    $out = sendSqlCommand("INSERT users VALUES('" . $id . "', '" . $info[0] . "', '" . $info[1] . "', '" . $info[2] . "', '" . $info[3] . "');", $uname, $passwd, $db);
    $out[2] = $id;
    return $out;

}
function installRoom($info, $uname, $passwd, $db){
    $id = $info['id'];
    $out = sendSqlCommand("INSERT rooms VALUES('" . $id . "', '" . $info['num'] . "');", $uname, $passwd, $db);
    $out[2] = $id;
    return $out;

}
