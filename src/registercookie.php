<?php
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$stid=$_POST['stid'];
$stem=$_POST['stem'];
$ranid = uniqid(rand());
echo $ranid;
//setcookie(phid, $ranid);
exec("cd registered_phid/ && echo '{$firstname}' >> {$ranid}");
?>