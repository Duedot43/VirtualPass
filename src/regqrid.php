<?php
$rnum=$_POST['rnum'];
$fh = fopen('qrid.txt','r');
$qrid = fgets($fh);
exec("cd registerd_qrids/ && echo '{$rnum}' >> {$qrid}");
header("Location: /stupid.php");
exit()
?>