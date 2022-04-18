<?php
$ini = parse_ini_file('../../config/config.ini');
if ($ini['overide_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['overide_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
$cookie_namez = "teacher";
$raniddd = rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand();
$uname = $_POST['uname'];
$passwd = $_POST['passwd'];
$ini = parse_ini_file('../../config/config.ini');
$unameck = $ini['teacher_uname'];
$passwdck = $ini['teacher_passwd'];
if ($uname == $unameck){
    if ($passwd == $passwdck){
        setcookie($cookie_namez, $raniddd, time() - (200), "/", $domain, TRUE, TRUE);
        setcookie($cookie_namez, $raniddd, time() + (200), "/", $domain, TRUE, TRUE);
        exec("echo -n " . $raniddd . " >> cookie/" . $raniddd);
        //exec("mkdir cookie/" . $raniddd);
        header("Location: /teacher/menu.php");
    } else{
        echo('<link href="style.css" rel="stylesheet" type="text/css" />Invalid!');
    }
} else{
    echo('<link href="style.css" rel="stylesheet" type="text/css" />Invalid!');
}




?>