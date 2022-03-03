<?php
$rnum=$_POST['rnum'];
//$fh = fopen('qrid.txt','r');
//$qrid = fgets($fh);
$qrid = $_GET['page'];
$date = exec("date");
if (isset($_POST['rnum'])) {
    //echo("you have {$dpt}");
    exec("echo ///////////////////////////////////////////////// >> log/inout.log");
    exec("echo '{$date}' >> log/inout.log");
    //echo($cookid);
    exec("echo 'qrid {$qrid} registred to room {$rnum}' >> log/inout.log");
    exec("echo ///////////////////////////////////////////////// >> log/inout.log");
    exec("cd registerd_qrids/ && echo '{$rnum}' >> {$qrid}");
    header("Location: /stupid.php");
    exit();
}
?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<tr>
<form method="post">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td colspan="3"><strong>First time setup! Please input the current room number of this qrcode to register this code.</strong></td>
</tr>
<tr>
<td width="78">Room Number</td>
<td width="6">:</td>
<td width="294"><input class="box" name="rnum" type="number" id="rnum" required></td>
</tr>
<tr>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input class="reg" type="submit" name="Submit" value="Submit"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>