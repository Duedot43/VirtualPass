<?php
function fail(){
    header('WWW-Authenticate: Basic realm="api"');
    header('HTTP/1.0 401 Unauthorized');
}
function err(){
    header('HTTP/1.0 406 Not Acceptable');
}
if (!isset($_GET['who']) or !isset($_GET['format'])   or $_GET['format'] != "room_id" and $_GET['format'] != "id_room" or $_GET['who'] != "all" and !is_numeric($_GET['who'])){
    err();
    $output = array("success"=>0, "reason"=>"invalid_format", "help_url"=>"");
    echo json_encode($output);
    exit();
}
if (!file_exists("../../mass.json")){
    err();
    $output = array("success"=>0, "reason"=>"no_mass", "help_url"=>"");
    echo json_encode($output);
    exit();
}
$main_json = json_decode(file_get_contents("../../mass.json"), true);
if (is_numeric($_GET['who'])){
    if (!in_array($_GET['who'], $main_json['room'], true)){
        err();
        $output = array("success"=>0, "reason"=>"no_room", "help_url"=>"");
        echo json_encode($output);
        exit();
    }
}
$config = parse_ini_file("../../config/config.ini");
if (isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] == $config['api_uname']){
    if (isset($_SERVER['PHP_AUTH_PW']) and $_SERVER['PHP_AUTH_PW'] == $config['api_passwd']){
        if (is_numeric($_GET['who'])){
            $output = array("success"=>1);
            if ($_GET['format'] == "id_room"){
                $output[$_GET['who']] = file_get_contents("../registerd_qrids/" . $_GET['who']);
                echo json_encode($output);
                exit();
            }
            if ($_GET['format'] == "room_id"){
                $output[file_get_contents("../registerd_qrids/" . $_GET['who'])] = $_GET['who'];
                echo json_encode($output);
                exit();
            }
        }
        if ($_GET['who'] == "all"){
            $main_json = json_decode(file_get_contents("../../mass.json"), true);
            $output = array("success"=>1);
            if ($_GET['format'] == "id_room"){
                foreach ($main_json['room'] as $room_id){
                    $output[$room_id] = file_get_contents("../registerd_qrids/" . $room_id);
                }
                echo json_encode($output);
                exit();
            }
            if ($_GET['format'] == "room_id"){
                foreach ($main_json['room'] as $room_id){
                    $output[file_get_contents("../registerd_qrids/" . $room_id)] = $room_id;
                }
                echo json_encode($output);
                exit();
            }
        }

    } else{
        fail();
        $output = array("success"=>0, "reason"=>"auth_fail", "help_url"=>"");
        echo json_encode($output);
        exit();
    }
} else{
    fail();
    $output = array("success"=>0, "reason"=>"auth_fail", "help_url"=>"");
    echo json_encode($output);
    exit();
}
?>