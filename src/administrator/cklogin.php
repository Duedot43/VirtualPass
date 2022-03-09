<?php
$cookie_namez = "admin";
$raniddd = uniqid(rand()) . uniqid(rand()) . uniqid(rand()) . uniqid(rand()) . uniqid(rand()) . uniqid(rand());
$uname = $_POST['uname'];
$passwd = $_POST['passwd'];
$unameck = exec("cat ../../auth/uname");
$passwdck = exec("cat ../../auth/passwd");
if ($uname == $unameck){
    if ($passwd == $passwdck){
        setcookie($cookie_namez, $raniddd, time() + (-30));
        setcookie($cookie_namez, $raniddd, time() + (30));
        exec("echo " . $raniddd . " >> cookie/" . $raniddd);
        //exec("mkdir cookie/" . $raniddd);
        header("Location:menu.php");
    } else{
        echo('<link href="style.css" rel="stylesheet" type="text/css" />Invalid!');
    }
} else{
    echo('<link href="style.css" rel="stylesheet" type="text/css" />Invalid!');
}




?>