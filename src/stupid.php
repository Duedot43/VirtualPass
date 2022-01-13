<?php
$myusername=$_POST['myusername'];
exec("rm qrid.txt");
exec("echo {$myusername} > qrid.txt");
?>