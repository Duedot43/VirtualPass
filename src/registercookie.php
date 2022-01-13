<?php
$cookie_name = "phid";
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$stid=$_POST['stid'];
$stem=$_POST['stem'];
$ranid = uniqid(rand());
echo $ranid;
setcookie($cookie_name, $ranid);
exec("cd registered_phid/ && echo '{$firstname}' >> {$ranid}");
exec("cd registered_phid/ && echo '{$lastname}' >> {$ranid}");
exec("cd registered_phid/ && echo '{$stid}' >> {$ranid}");
exec("cd registered_phid/ && echo '{$stem}' >> {$ranid}");
header("Location: /stupid.php");
?>