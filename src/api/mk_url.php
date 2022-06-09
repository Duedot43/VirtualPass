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
        $url = "https://" . $domain . "/index.php?room=" . $page_val . "&page=main";  
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