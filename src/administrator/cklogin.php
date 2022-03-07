<?php
$cookie_namez = "admin";
$raniddd = uniqid(rand()) . uniqid(rand()) . uniqid(rand()) . uniqid(rand()) . uniqid(rand()) . uniqid(rand());
$uname = $_POST['uname'];
$passwd = $_POST['passwd'];
if ($uname == "admin"){
    if ($passwd == "admin"){
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