<?php
function fail(){
    header('WWW-Authenticate: Basic realm="api"');
    header('HTTP/1.0 401 Unauthorized');
}
function err(){
    header('HTTP/1.0 406 Not Acceptable');
}
if (!isset($_GET['id']) or !isset($_GET['number']) or !isset($_GET['override']) or!is_numeric($_GET['id']) or !is_numeric($_GET['number']) ){
    err();
    $output = array("success"=>0, "reason"=>"invalid_options");
    echo json_encode($output);
    exit();
}
if (!file_exists("../../mass.json") and $_GET['override'] == 0){
    err();
    $output = array("success"=>0, "reason"=>"no_mass");
    echo json_encode($output);
    exit();
}
if ($_GET['override'] == 0){
    $main_json = json_decode(file_get_contents("../../mass.json"), true);
    foreach ($main_json['room'] as $json_room){
        if ($json_room == $_GET['id']){
            err();
            $output = array("success"=>0, "reason"=>"room_exists");
            echo json_encode($output);
            exit();
        }
    }
}
include "../usr_pre_fls/mk_mass.php";
$config = parse_ini_file("../../config/config.ini");
if (isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] == $config['api_uname']){
    if (isset($_SERVER['PHP_AUTH_PW']) and $_SERVER['PHP_AUTH_PW'] == $config['api_passwd']){
        $room = fopen("../registerd_qrids/" . $_GET['id'], "w");
        fwrite($room, $_GET['number']);
        room($_GET['id'], "../../mass.json");
        fclose($room);
        $output = array("success"=>1, "reason"=>"");
        echo json_encode($output);
    } else{
        fail();
        $output = array("success"=>0, "reason"=>"auth_fail");
        echo json_encode($output);
        exit();
    }
} else{
    fail();
    $output = array("success"=>0, "reason"=>"auth_fail");
    echo json_encode($output);
    exit();
}