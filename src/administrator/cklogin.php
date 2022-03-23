<?php
$domain = $_SERVER['SERVER_NAME'];
$cookie_namez = "admin";
$raniddd = uniqid(rand()) . uniqid(rand()) . uniqid(rand()) . uniqid(rand()) . uniqid(rand()) . uniqid(rand());
$uname = $_POST['uname'];
$passwd = $_POST['passwd'];
$ini = parse_ini_file('../../config/config.ini');
$unameck = $ini['admin_uname'];
$passwdck = $ini['admin_passwd'];
if ($uname == $unameck){
    if ($passwd == $passwdck){
        exec("please stop");
        setcookie($cookie_namez, $raniddd, time() - (30), "/", $domain, TRUE, TRUE);
        setcookie($cookie_namez, $raniddd, time() + (30), "/", $domain, TRUE, TRUE);
        exec("echo " . $raniddd . " >> cookie/" . $raniddd);
        //exec("mkdir cookie/" . $raniddd);
        header("Location: /administrator/menu.php");
    } else{
        echo('<link href="style.css" rel="stylesheet" type="text/css" />Invalid!');
    }
} else{
    echo('<link href="style.css" rel="stylesheet" type="text/css" />Invalid!');
}




?>