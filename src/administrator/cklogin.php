<?php
$ini = parse_ini_file('../../config/config.ini');
if ($ini['overide_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['overide_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
$cookie_namez = "admin";
$raniddd = rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand();
$uname = $_POST['uname'];
$passwd = $_POST['passwd'];
$ini = parse_ini_file('../../config/config.ini');
$unameck = $ini['admin_uname'];
$passwdck = $ini['admin_passwd'];
if ($uname == $unameck){
    if ($passwd == $passwdck){
        setcookie($cookie_namez, $raniddd, time() - (30), "/", $domain, TRUE, TRUE);
        setcookie($cookie_namez, $raniddd, time() + (30), "/", $domain, TRUE, TRUE);
        $cookie = fopen("cookie/" . $raniddd, "w");
        fwrite($cookie, $raniddd);
        //exec("echo -n " . $raniddd . " >> cookie/" . $raniddd);
        //exec("mkdir cookie/" . $raniddd);
        header("Location: /administrator/menu.php");
    } else{
        echo('<link href="style.css" rel="stylesheet" type="text/css" />Invalid!');
    }
} else{
    echo('<link href="style.css" rel="stylesheet" type="text/css" />Invalid!');
}




?>