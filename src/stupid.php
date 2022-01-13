<?php
$cookie_name = "phid";
$myusername=$_POST['myusername'];
exec("rm qrid.txt");
exec("echo {$myusername} > qrid.txt");
if(!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
    header("Location: /register.html");

  } else {
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $_COOKIE[$cookie_name];
  }
?>