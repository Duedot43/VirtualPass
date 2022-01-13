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
    //echo "Value is: " . $_COOKIE[$cookie_name];
    $catin = exec("ls departed/ | grep " . $_COOKIE[$cookie_name]);
    $catout = exec("ls registered_phid/ | grep " . $_COOKIE[$cookie_name]);
    echo ("Hall pass registerd");
    //echo " out ", $catout, " in ", $catin, " cookie ", $_COOKIE[$cookie_name];
    //1 = departed
    if ($catout == $_COOKIE[$cookie_name]) {
      $fh = fopen('registered_phid/' . $_COOKIE[$cookie_name],'r');
      $cookid = fgets($fh); 
      $dpt = ("Departed");
      exec("mv -v registered_phid/" . $_COOKIE[$cookie_name] . " departed/");
    }
      else{
        $fh = fopen('departed/' . $_COOKIE[$cookie_name],'r');
        $cookid = fgets($fh); 
        $dpt = ("Arrived");
        exec("mv -v departed/" . $_COOKIE[$cookie_name] . " registered_phid/");
      }
    $date = exec("date");
    exec("echo ///////////////////////////////////////////////// >> log/inout.log");
    exec("echo '{$date}' >> log/inout.log");
    //echo($cookid);
    exec("echo '{$cookid}' >> log/inout.log");
    $rid = exec("cat registerd_qrids/{$qrid}");
    exec("echo '{$dpt}' '{$rid}' >> log/inout.log");
    exec("echo ///////////////////////////////////////////////// >> log/inout.log");

  }
?>