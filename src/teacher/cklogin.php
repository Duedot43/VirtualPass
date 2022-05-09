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
include "../usr_pre_fls/teacher_auth.php";
$authen = auth($uname, $passwd);
if ($authen == 1){
  setcookie($cookie_namez, $raniddd, time() - (200), "/", $domain, TRUE, TRUE);
  setcookie($cookie_namez, $raniddd, time() + (200), "/", $domain, TRUE, TRUE);
  $cookie = fopen("cookie/" . $raniddd, "w");
  fwrite($cookie, $raniddd);
  //exec("echo -n " . $raniddd . " >> cookie/" . $raniddd);
  //exec("mkdir cookie/" . $raniddd);
  header("Location: /teacher/menu.php");
} else{
    echo($authen);
}




?>