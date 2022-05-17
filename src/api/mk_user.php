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