<?php
$cookie_name = "phid";
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$stid=$_POST['stid'];
$stem=$_POST['stem'];
$ranid = uniqid(rand());
echo $ranid;
setcookie($cookie_name, $ranid, time() + (86400 * 360));
exec("cd registered_phid/ && echo '{$firstname}' '{$lastname}' '{$stid}' '{$stem}' >> {$ranid}");
exec("echo '{$firstname} registered with phid {$ranid} >> log/inout.log");
exec("echo ///////////////////////////////////////////////// >> log/inout.log");
exec("echo '{$date}' >> log/inout.log");
exec("echo '{$firstname} registered with phid {$ranid}' >> log/inout.log");
exec("echo ///////////////////////////////////////////////// >> log/inout.log");
header("Location: /stupid.php");
?>