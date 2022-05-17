<?php
/*
MIT License

Copyright (c) 2022 Jack Gendill

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/
function check_phid($pid){
  if (is_numeric($pid)){
  }
  else{
      echo("Invalid! not numeric");
    
    exit();
  }
}
if (!isset($_COOKIE['teacher'])){
  exec("rm ../cookie/*");
  header("Location: /teacher/index.html");
  exit();
}
else{
  if (!file_exists("../cookie/" . $_COOKIE['teacher'])){
      header("Location:/teacher/index.html");
      exit();
  }
}
check_phid($_COOKIE['teacher']);

function check_string($pid){
  if (is_numeric($pid)){
  }
  else{
    echo("Invalid phid cookie!");
    
    exit();
  }
}
include "../../usr_pre_fls/mk_mass.php";
$qrid = $_GET['page'];
//get rid of this
$date = date(DATE_ATOM);
//fairly simple check if the user has entered the room number log it put it in the qrid folder and send it back to stupid
if (isset($_POST['rnum'])) {
  if ($_POST['rnum'] == ""){
    if (!file_exists("../../registerd_qrids/" . $qrid)){
      //NOTE: Dont ask me why its called stupid.php im still learning PHP and that was not easy to write
      header("Location: /teacher/mk_room/ck_qrid.php?page=" . $qrid);
      exit();
      } else{
          echo("QRID already set please try again");
          exit();
      }
    }
    $rnum=$_POST['rnum'];
    $inithing = parse_ini_file("../../../config/config.ini");
    check_string($qrid);
    if (!file_exists("../../registerd_qrids/" . $qrid)){
    $room = fopen("../../registerd_qrids/" . $qrid, "w");
    check_string($rnum);
    room($qrid, "../../../mass.json");
    fwrite($room, $rnum);
    //NOTE: Dont ask me why its called stupid.php im still learning PHP and that was not easy to write
    header("Location: /teacher/mk_room/ck_qrid.php?page=" . $qrid);
    exit();
    } else{
        echo("QRID already set please try again");
        exit();
    }
}
?>
<title>QR Code</title>
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<tr>
<form method="post">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td colspan="3"><strong>Please enter the room you would like this QR code to be in.<br>Enter nothing if you dont want to manualy set the room and trust the students to set it correctly</strong></td>
</tr>
<tr>
<td width="78">Room Number</td>
<td width="6">:</td>
<td width="294"><input class="box" name="rnum" autocomplete="off" type="number" id="rnum"></td>
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