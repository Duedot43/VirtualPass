<?php
//really delete the user
function check_phid($pid){
    if (is_numeric($pid)){
    }
    else{
      echo("Invalid!");
      
      exit();
    }
  }
$cookie_name = "phid";
if(isset($_COOKIE[$cookie_name])){
    check_phid($_COOKIE[$cookie_name]);
    if (file_exists("registered_phid/" . $_COOKIE[$cookie_name])){
        //exec("rm -rf departed/" . $_COOKIE[$cookie_name]);
        unlink("registered_phid/" . $_COOKIE[$cookie_name]);
        //exec("rm registered_phid/" . $_COOKIE[$cookie_name]);
        setcookie("phid", "", time() - 9999999999);
    }else{
        echo("Internal server error your file is not here! please try again...");
    }
} else{
    echo("Internal server error your cookie is not here! please try again...");
}

?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<title>Bye!</title>
User removed.
