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
if (!isset($_GET['room']) or !is_numeric($_GET['room'])){
    err();
    $output = array("success"=>0, "reason"=>"invalid_room", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Remove#invalid-room");
    echo json_encode($output);
    exit();
}
if (!file_exists("../../mass.json")){
    err();
    $output = array("success"=>0, "reason"=>"no_mass", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Remove#no-mass-1");
    echo json_encode($output);
    exit();
}
$main_json = json_decode(file_get_contents("../../mass.json"), true);
if (!in_array($_GET['room'], $main_json['room'], true)){
    err();
    $output = array("success"=>0, "reason"=>"no_room", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Remove#no-room");
    echo json_encode($output);
    exit();
}
$config = parse_ini_file("../../config/config.ini");
if (isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] == $config['api_uname']){
    if (isset($_SERVER['PHP_AUTH_PW']) and $_SERVER['PHP_AUTH_PW'] == $config['api_passwd']){
        unlink("../registerd_qrids/" . $_GET['room']);
        $main_json = json_decode(file_get_contents("../../mass.json"), true);
        $main_json['room'] = \array_diff($main_json['room'], [$_GET['room']]);
        $json_out = fopen("../../mass.json", "w");
        fwrite($json_out, json_encode($main_json));
        fclose($json_out);
        $output = array("success"=>1, "reason"=>"", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Remove#remove-room-api");
        echo json_encode($output);
    } else{
        fail();
        $output = array("success"=>0, "reason"=>"auth_fail", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Remove#authentication-failed-1");
        echo json_encode($output);
        exit();
    }
} else{
    fail();
    $output = array("success"=>0, "reason"=>"auth_fail", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Remove#authentication-failed-1");
    echo json_encode($output);
    exit();
}
?>