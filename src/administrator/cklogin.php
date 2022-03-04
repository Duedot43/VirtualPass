<?php
$uname = $_POST['uname'];
$passwd = $_POST['passwd'];
if ($uname == "admin"){
    if ($passwd == "admin"){
        header("Location:menu.php");
    } else{
        echo('<link href="style.css" rel="stylesheet" type="text/css" />Invalid!');
    }
} else{
    echo('<link href="style.css" rel="stylesheet" type="text/css" />Invalid!');
}




?>