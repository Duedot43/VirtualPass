<?php
include "include/modules.php";
$domain = getDomain();
if (!isset($_GET['room'])) {
    header('Location: /');
    exit();
}
$config = parse_ini_file("../config/config.ini");
if (isset($_GET['room']) and roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
    header('Location: /?room=' . $_GET['room']);
    exit();
}


// now we make the room
if (isset($_POST['rnum'])) {
    $installRoom = installRoom(array("id"=>preg_replace("/[^0-9.]+/i", "", $_GET['room']), "num"=>preg_replace("/[^0-9.]+/i", "", $_POST['rnum'])), "root", $config['sqlRootPasswd'], "VirtualPass");
    header("Location: /?room=" . $_GET['room']);
    exit();

}
?>
<title>Register Room</title>
<head>
    <link href="/public/style.css" rel="stylesheet" type="text/css" />
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