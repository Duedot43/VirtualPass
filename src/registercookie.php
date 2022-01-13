<?php
$cookie_name = "phid";
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$stid=$_POST['stid'];
$stem=$_POST['stem'];
$ranid = uniqid(rand());
echo $ranid;
setcookie($cookie_name, $ranid);
exec("cd registered_phid/ && echo '{$firstname}' '{$lastname}' '{$stid}' '{$stem}' >> {$ranid}");
header("Location: /stupid.php");
?>