<?php
function vp_auth(string $config, string $uname, string $passwd, string $branch)
{
    $configArr = parse_ini_file($config);
    if ($branch == "api") {
        $realUname = $configArr['api_uname'];
        $realPasswd = $configArr['api_passwd'];
    } elseif ($branch == "teach") {
        $realUname = $configArr['teach_uname'];
        $realPasswd = $configArr['teach_passwd'];
    } elseif ($branch == "admin") {
        $realUname = $configArr['admin_uname'];
        $realPasswd = $configArr['admin_passwd'];
    }
    if ($uname == $realUname and $passwd == $realPasswd) {
        return true;
    } else {
        return false;
    }
}
function apiAuth(string $key, string $mass){
    $mass = readJson($mass);
    if ($mass == false){
        return 1;
    }
    if (in_array($key, $mass['apiKeys'])){
        return true;
    } else{
        return false;
    }
}
function read_file(string $file)
{
    if (file_exists($file)) {
        return file_get_contents($file);
    } else {
        return false;
    }
}
function readJson(string $file)
{
    if (file_exists($file)) {
        return json_decode(file_get_contents($file), true);
    } else {
        return false;
    }
}
function authFail(){
    header('WWW-Authenticate: Basic realm="api"');
    header('HTTP/1.0 401 Unauthorized');
}
function err(){
    header('HTTP/1.0 406 Not Acceptable');
}
function ck_request(){
    if ($_SERVER['REQUEST_METHOD'] == "GET" or $_SERVER['REQUEST_METHOD'] == "HEAD" or $_SERVER['REQUEST_METHOD'] == "POST" or $_SERVER['REQUEST_METHOD'] == "PUT" or $_SERVER['REQUEST_METHOD'] == 'DELETE' or $_SERVER['REQUEST_METHOD'] == "CONNECT" or $_SERVER['REQUEST_METHOD'] == "OPTIONS" or $_SERVER['REQUEST_METHOD'] == "TRACE" or $_SERVER['REQUEST_METHOD'] == "PATCH"){
        return true;
    } else{
        return false;
    }
}
function unsetValue(array $array, array $value, $strict = TRUE)
{
    foreach ($value as $val){
        if(($key = array_search($val, $array, $strict)) !== FALSE) {
            unset($array[$key]);
        }
    }
    $count = -1;
    $new_arr = array();
    foreach ($array as $arr_val){
        if ($arr_val == ""){
            unset($array[$count]);
        } else{
            $new_arr[$count] = $arr_val;
        }
        $count = $count+1;
    }
    return $new_arr;
}
function ifnumeric($value){
    if (is_numeric($value)){
        return true;
    } else{
        return false;
    }
}
function verifyStudentPut(array $studentArray){
    if (isset($studentArray['fname']) and isset($studentArray['lname']) and isset($studentArray['email']) and isset($studentArray['id']) and isset($studentArray['student_activ']) and isset($studentArray['rooms']) and isset($studentArray['sctivity']) and isset($studentArray['activity']['cnum10'])){
        return true;
    } else{
        return false;
    }
}
?>