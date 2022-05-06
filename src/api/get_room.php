<?php
function fail(){
    header('WWW-Authenticate: Basic realm="api"');
    header('HTTP/1.0 401 Unauthorized');
}
function err(){
    header('HTTP/1.0 406 Not Acceptable');
}
if (!isset($_GET['who'])){
    err();
    $output = array("success"=>0, "reason"=>"no_who", "help_url"=>"");
    echo json_encode($output);
    exit();
}
if (!file_exists("../../mass.json")){
    err();
    $output = array("success"=>0, "reason"=>"no_mass", "help_url"=>"");
    echo json_encode($output);
    exit();
}
$main_json = file_get_contents("../../mass.json");
if (is_numeric($_GET['who'])){
    if (!in_array($_GET['who'], $main_json['user'], true)){
        err();
        $output = array("success"=>0, "reason"=>"no_user", "help_url"=>"");
        echo json_encode($output);
        exit();
    }
}
$config = parse_ini_file("../../config/config.ini");
if (isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] == $config['api_uname']){
    if (isset($_SERVER['PHP_AUTH_PW']) and $_SERVER['PHP_AUTH_PW'] == $config['api_passwd']){

        
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