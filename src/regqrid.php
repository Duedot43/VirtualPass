<?php
function check_string($pid){
    if (is_numeric($pid)){
    }
    else{
      echo("Invalid phid cookie!");
      
      exit();
    }
  }
  
$qrid = $_GET['page'];
$date = date(DATE_ATOM);
//fairly simple check if the user has entered the room number log it put it in the qrid folder and send it back to stupid
if (isset($_GET['page'])){
  if ($_GET['page'] == ""){
    echo("No page value!");
    exit();
  }
} else{echo("No page value!");exit();}
include "usr_pre_fls/mk_mass.php";
if (isset($_POST['rnum'])) {
    $rnum=$_POST['rnum'];
    $inithing = parse_ini_file("../config/config.ini");
    check_string($qrid);
    $room = fopen("registerd_qrids/" . $qrid, "w");
    check_string($rnum);
    fwrite($room, $rnum);
    room($qrid, "../mass.json");

    //NOTE: Dont ask me why its called stupid.php im still learning PHP and that was not easy to write
    header("Location: /stupid.php?page=" . $qrid);
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