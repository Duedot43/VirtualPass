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
        if (is_numeric($_GET['who'])){
            $output = array("success"=>1);
            $user_ini = parse_ini_file("../registered_phid/" . $_GET['who'], true);
            if ($user_ini['usrinfo']['student_activity'] == "Departed"){
                $output[$_GET['who']] = $user_ini;
                echo json_encode($user_ini);
                exit();
            }
        }
        if ($_GET['who'] == "all"){
            $mass_json = json_decode(file_get_contents("../../mass.json"), true);
            $output = array("success"=>1);
            foreach ($mass_json['user'] as $user_id){
                $user_ini = parse_ini_file("../registered_phid/" . $user_id, true);
                if ($user_ini['usrinfo']['student_activity'] == "Departed"){
                    $output[$user_id] = $user_ini;
                }
            }
            echo json_encode($output);
            exit();
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