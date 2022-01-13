<?php
$cookie_name = "phid";
$qrid=$_POST['qrid'];
exec("rm qrid.txt");
exec("echo {$qrid} > qrid.txt");
$output = exec("tree -i --noreport registerd_qrids/ | grep -o {$qrid}");
if($output != $qrid) {
    header("Location: /regqrid.html");
    exit();
} 
if(!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
    header("Location: /register.html");
    exit();
  } else {
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $_COOKIE[$cookie_name];

  }
?>