<?php
function fail(){
    header('WWW-Authenticate: Basic realm="api"');
    header('HTTP/1.0 401 Unauthorized');
}
function err(){
    header('HTTP/1.0 406 Not Acceptable');
}
if (!isset($_GET['format'])){
    err();
    $output = array("success"=>0, "reason"=>"format_missing", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Make#format-missing");
    echo json_encode($output);
    exit();
}
$config = parse_ini_file("../../config/config.ini");
if (isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] == $config['api_uname']){
    if (isset($_SERVER['PHP_AUTH_PW']) and $_SERVER['PHP_AUTH_PW'] == $config['api_passwd']){
        $ini = parse_ini_file('../../config/config.ini');
        if ($ini['overide_automatic_domain_name'] == "1"){
        $domain = $ini['domain_name'];
        }
        if ($ini['overide_automatic_domain_name'] != "1"){
        $domain = $_SERVER['SERVER_NAME'];
        }
        $page_val = rand();
        $url = "https://" . $domain . "/stupid.php?page=" . $page_val;  
        if ($_GET['format'] == "json"){  
            $output = array("raw_url"=>$url, "room_id"=>$page_val, "domain"=>$domain, "success"=>1);
            echo json_encode($output);
            exit();
        } else{
            echo $url;
            exit();
        }
    } else{
        fail();
        $output = array("success"=>0, "reason"=>"auth_fail", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Make#authentication-failed");
        echo json_encode($output);
        exit();
    }
} else{
    fail();
    $output = array("success"=>0, "reason"=>"auth_fail", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Make#authentication-failed");
    echo json_encode($output);
    exit();
}
?>