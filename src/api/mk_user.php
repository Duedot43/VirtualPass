<?php
function fail(){
    header('WWW-Authenticate: Basic realm="api"');
    header('HTTP/1.0 401 Unauthorized');
}
function err(){
    header('HTTP/1.0 406 Not Acceptable');
}
if (!isset($_GET['fname']) or !isset($_GET['lname']) or !isset($_GET['id']) or !isset($_GET['email']) or !ctype_alpha($_GET['fname']) or !ctype_alpha($_GET['lname']) or !is_numeric($_GET['id']) or !filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){
    err();
    $output = array("success"=>0, "reason"=>"info_invalid", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Make#info-invalid");
    echo json_encode($output);
    exit();
}
$config = parse_ini_file("../../config/config.ini");
include "../usr_pre_fls/mk_mass.php";
if (isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] == $config['api_uname']){
    if (isset($_SERVER['PHP_AUTH_PW']) and $_SERVER['PHP_AUTH_PW'] == $config['api_passwd']){
        $ranid = rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand();
        $inifl = fopen("../registered_phid/" . $ranid, "w");
        $tet = ("[usrinfo]\nfirst_name=" . $_GET['fname'] . "\nlast_name=" . $_GET['lname'] . "\nstudent_id=" . $_GET['id'] . "\nstudent_email=" . $_GET['email'] . "\nstudent_activity=Arrived\n[srvinfo]\ndayofmonth_gon=\nhour_gon=\nminute_gon=\ndayofmonth_arv=\nhour_arv=\nminute_arv=\n[room]\n");
        fwrite($inifl, $tet);
        fclose($inifl);
        user($ranid, "../../mass.json");
        $output = array("user_id"=>$ranid, "success"=>1, "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Make#add-user-api");
        echo json_encode($output);
        exit();
    } else{
        fail();
        $output = array("success"=>0, "reason"=>"auth_fail", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Make#authentication-failed-2");
        echo json_encode($output);
        exit();
    }
} else{
    fail();
    $output = array("success"=>0, "reason"=>"auth_fail", "help_url"=>"https://github.com/Duedot43/VirtualPass/wiki/Make#authentication-failed-2");
    echo json_encode($output);
    exit();
}
?>