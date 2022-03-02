<?php
$cookie_name = "phid";
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$stid=$_POST['stid'];
$stem=$_POST['stem'];
$ranid = uniqid(rand());
echo $ranid;
$date = exec("date");
if(!isset($_COOKIE[$cookie_name])) {
    setcookie($cookie_name, $ranid, time() + (86400 * 360));
    exec("cd registered_phid/ && echo '{$firstname}' '{$lastname}' '{$stid}' '{$stem}' >> {$ranid}");
    exec("echo '{$firstname} registered with phid {$ranid} >> log/inout.log");
    exec("echo ///////////////////////////////////////////////// >> log/inout.log");
    exec("echo '{$date}' >> log/inout.log");
    exec("echo '{$firstname} registered with phid {$ranid}' >> log/inout.log");
    exec("echo ///////////////////////////////////////////////// >> log/inout.log");
    header("Location: /stupid.php");
    exit();
}
    else {
    
    //echo "Cookie '" . $cookie_name . "' is set!<br>";
    //echo "Value is: " . $_COOKIE[$cookie_name];
    $catine = exec("ls departed/ | grep " . $_COOKIE[$cookie_name]);
    $catoutee = exec("ls registered_phid/ | grep " . $_COOKIE[$cookie_name]);
    //echo ("Hall pass registerd<br>");
    //echo ("Please rescan the QR code if this is your first time.<br>");
    //echo " out ", $catout, " in ", $catin, " cookie ", $_COOKIE[$cookie_name];
    //1 = departed
    $cook = ("0");
    if ($catoutee == $_COOKIE[$cookie_name]) {
      //user already registered redirect
      header("Location: /stupid.php");
      $cooki = ("1");
    }
    if ($catine == $_COOKIE[$cookie_name]) {
      //user already registered redirect
      header("Location: /stupid.php");
      $cooki = ("1");
    }
    if ($cooki == "0") {
      //cookie error re register cookie and delete the cookie
      setcookie("phid", "", time() - 9999999999);
      header("Location: /register.html");
    }
}
//setcookie($cookie_name, $ranid, time() + (86400 * 360));
//exec("cd registered_phid/ && echo '{$firstname}' '{$lastname}' '{$stid}' '{$stem}' >> {$ranid}");
//exec("echo '{$firstname} registered with phid {$ranid} >> log/inout.log");
//exec("echo ///////////////////////////////////////////////// >> log/inout.log");
//exec("echo '{$date}' >> log/inout.log");
//exec("echo '{$firstname} registered with phid {$ranid}' >> log/inout.log");
//exec("echo ///////////////////////////////////////////////// >> log/inout.log");
//header("Location: /stupid.php");
?>