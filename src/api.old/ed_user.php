<?php
/*
MIT License

Copyright (c) 2022 Jack Gendill

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/
function fail(){
    header('WWW-Authenticate: Basic realm="api"');
    header('HTTP/1.0 401 Unauthorized');
}
function err(){
    header('HTTP/1.0 406 Not Acceptable');
}
function config_set($config_file, $section, $key, $value) {
    $config_data = parse_ini_file($config_file, true);
    $config_data[$section][$key] = $value;
    $new_content = '';
    foreach ($config_data as $section => $section_content) {
        $section_content = array_map(function($value, $key) {
            return "$key=$value";
        }, array_values($section_content), array_keys($section_content));
        $section_content = implode("\n", $section_content);
        $new_content .= "[$section]\n$section_content\n";
    }
    file_put_contents($config_file, $new_content);
  }
function ck_section($usr_sec){
    if ($usr_sec == "usrinfo" or $usr_sec == "srvinfo" or $usr_sec == "room"){
        return true;
    } else{
        return false;
    }
}
function ck_variable($usr_sec, $usr_var){
    if ($usr_sec == "usrinfo" and $usr_var == "first_name" or $usr_var == "last_name" or $usr_var == "student_id" or $usr_var == "student_email" or $usr_var == "student_activity"){
        return true;
    }
    if ($usr_sec == "srvinfo" and $usr_var == "dayofmonth_gon" or $usr_var == "hour_gon" or $usr_var == "minute_gon" or $usr_var == "dayofmonth_arv" or $usr_var == "hour_arv" or $usr_var == "minute_arv"){
        return true;
    }
    if ($usr_sec == "room" and is_numeric($usr_var)){
        return true;
    }
    return false;
}
function ck_value($user_sec, $user_var, $user_val){
    //check user info variables
    if ($user_sec == "usrinfo"){
        if ($user_var == "first_name" and ctype_alpha($user_val)){
            return true;
        }
        if ($user_var == "last_name" and ctype_alpha($user_val)){
            return true;
        }
        if ($user_var == "student_id" and is_numeric($user_val)){
            return true;
        }
        if ($user_var == "student_email" and filter_var($user_val, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        if ($user_var == "student_activity" and $user_val == "Departed" or $user_val == "Arrived"){
            return true;
        }
        return false;
    }
    //Check server info variables
    if ($user_sec == "srvinfo"){
        if (is_numeric($user_val)){
            return true;
        }
        return false;
    }
    //Check room variables
    if ($user_sec == "room"){
        if ($user_var == $user_val){
            return true;
        }
        return false;
    }
}
if (!isset($_GET['user']) or !isset($_GET['section']) or !isset($_GET['variable']) or !isset($_GET['value'])  or !is_numeric($_GET['user']) or !ck_section($_GET['section']) or !ck_variable($_GET['section'], $_GET['variable']) or !ck_value($_GET['section'], $_GET['variable'], $_GET['value'])){
    err();
    $output = array("success"=>0, "reason"=>"invalid_option", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Edit#invalid-option");
    echo json_encode($output);
    exit();
}
if (!file_exists("../../mass.json")){
    err();
    $output = array("success"=>0, "reason"=>"no_mass", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Edit#no-mass");
    echo json_encode($output);
    exit();
}
$main_json = json_decode(file_get_contents("../../mass.json"), true);
if (!in_array($_GET['user'], $main_json['user'], true)){
    err();
    $output = array("success"=>0, "reason"=>"no_user", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Edit#no-user");
    echo json_encode($output);
    exit();
}
$config = parse_ini_file("../../config/config.ini");
if (isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] == $config['api_uname']){
    if (isset($_SERVER['PHP_AUTH_PW']) and $_SERVER['PHP_AUTH_PW'] == $config['api_passwd']){
        config_set("../registered_phid/" . $_GET['user'], $_GET['section'] , $_GET['variable'], $_GET['value']);
        $output = json_encode(array("success"=>1, "reason"=>"", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Edit#editing-users-api"));
        echo $output;
        exit();
    } else{
        fail();
        $output = array("success"=>0, "reason"=>"auth_fail", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Edit#authentication-failed");
        echo json_encode($output);
        exit();
    }
} else{
    fail();
    $output = array("success"=>0, "reason"=>"auth_fail", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Edit#authentication-failed");
    echo json_encode($output);
    exit();
}
?>