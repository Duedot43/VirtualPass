<?php
$rnum=$_POST['rnum'];
$fh = fopen('qrid.txt','r');
$qrid = fgets($fh);
$date = exec("date");
echo("you have {$dpt}");
exec("echo ///////////////////////////////////////////////// >> log/inout.log");
exec("echo '{$date}' >> log/inout.log");
//echo($cookid);
exec("echo 'qrid {$qrid} registred to room {$rnum}' >> log/inout.log");
exec("echo ///////////////////////////////////////////////// >> log/inout.log");
exec("cd registerd_qrids/ && echo '{$rnum}' >> {$qrid}");
header("Location: /stupid.php");
exit()
?>