<?php
$cookie_name = "phid";
$qrid=$_POST['qrid'];
exec("rm qrid.txt");
exec("echo '{$qrid}' > qrid.txt");
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
    $date = exec("date");
    exec("echo '{$date}' >> log/inout.log");
    exec("echo . >> log/inout.log");
    $fh = fopen('registered_phid/' . $_COOKIE[$cookie_name],'r');
    $cookid = fgets($fh); 
    echo($cookid);
    exec("echo '{$cookid}' >> log/inout.log");

  }
?>