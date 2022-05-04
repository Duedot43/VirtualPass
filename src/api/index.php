<?php
function fail(){
    header('WWW-Authenticate: Basic realm="api"');
    header('HTTP/1.0 401 Unauthorized');
}
function invalid(){
    header('HTTP/1.0 405 Method Not Allowed');
}
function err(){
    header('HTTP/1.0 406 Not Acceptable');
}
//nooooo this code is not stolen fron StackOverflow no never!
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
  //nooooo this code is not stolen fron StackOverflow no never!
//if something does not want to be set it can be set to None required values are [who, what]
//format = <ip>/api/index.php?who=[all, <user_num>, room, config]&item=[user, room]&what=[all, <room_id>, departed, arrived, time_out]&set=[<any value in config.ini>,<any value in a user ini>]
$config = parse_ini_file("../../config/config.ini");
if (isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] == $config['api_uname']){
    if (isset($_SERVER['PHP_AUTH_PW']) and $_SERVER['PHP_AUTH_PW'] == $config['api_passwd']){
        $main_json = json_decode(file_get_contents("../../mass.json"), true);
        //Who to get the info from
        if ($_GET['who'] == "all"){
            //get all user info
            if ($_GET['what'] == "all"){
                //get all whats aka just make a json file of whats in the ini file
                if ($_GET['item'] == "user" or $_GET['item'] == "room"){
                    //check if the value for item is correct
                    $output = array();
                    foreach ($main_json[$_GET['item']] as $item){
                        $user_ini = parse_ini_file("../registered_phid/" . $item, true);
                        $output[$item] = $user_ini;
                    echo json_encode($output);
                    }
                } else{
                    //send an error not acceptable 
                    err();
                }
            }
            //get all user info
            //get all the users that are departed
            if ($_GET['what'] == "departed"){
                $output = array();
                foreach ($main_json["user"] as $user_id){
                    $user_ini = parse_ini_file("../registered_phid/" . $user_id, true);
                    if ($user_ini['usrinfo']['student_activity'] == "Departed"){
                        $output[$user_id]["activity"] = $user_ini['usrinfo']['student_activity'];
                    }
                }
                echo json_encode($output);
            }
            //get all the users that are departed
            //get all the users arrived
            if ($_GET['what'] == "arrived"){
                $output = array();
                foreach ($main_json["user"] as $user_id){
                    $user_ini = parse_ini_file("../registered_phid/" . $user_id, true);
                    if ($user_ini['usrinfo']['student_activity'] == "Arrived"){
                        $output[$user_id]["activity"] = $user_ini['usrinfo']['student_activity'];
                    }
                }
                echo json_encode($output);
            }
            //get all users arrived
            //get the time out of all users
            if ($_GET['what'] == "time_out"){
                $output = array();
                foreach ($main_json["user"] as $user_id){
                    $user_ini = parse_ini_file("../registered_phid/" . $user_id, true);
                    $output[$user_id] = $user_ini['srvinfo'];
                }
                echo json_encode($output);
            }
            //get the time out of all users
        }
        if (is_numeric($_GET['who'])){
            //get users number
            //get all user info
            if ($_GET['what'] == "all"){
                //get all whats aka just make a json file of whats in the ini file
                if ($_GET['item'] == "user"){
                    //check if the value for item is correct
                    $output = array();
                    $user_ini = parse_ini_file("../registered_phid/" . $_GET['who'], true);
                    $output[$_GET['who']] = $user_ini;
                    echo json_encode($output);
                    exit();
                } else{
                    //send an error not acceptable 
                    err();
                }
            }
            //get a users info
            if ($_GET['set'] == "first_name" or $_GET['set'] == "last_name" or $_GET['set'] == "student_id" or $_GET['set'] == "student_email" or $_GET['set'] == "student_activity"){
                config_set("../registered_phid/" . $_GET['who'], "usrinfo", $_GET['set'], $_GET['item']);
            } else{
                err();
            }
        }
        if ($_GET['who'] == "room"){
            //room numbers
        }
        if ($_GET['who'] == "config"){
            //config info
        }
















































    } else{
        fail();
    }
} else{
    fail();
}