<?php
//$fh = fopen('qrid.txt','r');
//$qrid = fgets($fh);
function check_string($num){
    if (!filter_var($num, FILTER_VALIDATE_INT) === false) {
        echo("Valid");
    } else {
        echo("Invalid");
        exit();
    }
}
$qrid = $_GET['page'];
$date = exec("date");
//fairly simple check if the user has entered the room number log it put it in the qrid folder and send it back to stupid
if (isset($_POST['rnum'])) {
    $rnum=$_POST['rnum'];
    //echo("you have {$dpt}");
    $inithing = parse_ini_file("../../config/config.ini");
    if ($inithing['enable_insecure_general_logs'] == "1"){
    exec("echo ///////////////////////////////////////////////// >> log/inout.log");
    exec("echo '{$date}' >> log/inout.log");
    //echo($cookid);
    exec("echo 'qrid {$qrid} registred to room {$rnum}' >> log/inout.log");
    exec("echo ///////////////////////////////////////////////// >> log/inout.log");
    }
    check_string($qrid);
    $room = fopen("registerd_qrids/" . $qrid, "w");
    check_string($rnum);
    fwrite($room, $rnum);
    //exec("cd registerd_qrids/ && echo '{$rnum}' >> {$qrid}");
    //NOTE: Dont ask me why its called stupid.php im still learning PHP and that was not easy to write
    header("Location: /mk_room/ck_qrid.php");
    exit();
}
?>
<title>QR Code</title>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<tr>
<form method="post">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td colspan="3"><strong>Please enter the room you would like this QR code to be in.</strong></td>
</tr>
<tr>
<td width="78">Room Number</td>
<td width="6">:</td>
<td width="294"><input class="box" name="rnum" autocomplete="off" type="number" id="rnum" required></td>
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