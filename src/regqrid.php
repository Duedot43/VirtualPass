<?php
$rnum=$_POST['rnum'];
$qrid=$_POST['qrid'];
exec("cd registerd_qrids/ && echo '{$rnum}' >> {$qrid}");
header("Location: /stupid.php");
?>