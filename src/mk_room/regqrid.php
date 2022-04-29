<?php
function check_phid($pid){
    if (is_numeric($pid)){
    }
    else{
        echo("Invalid! not numeric");
      
      exit();
    }
  }
  if (!isset($_COOKIE['admin'])){
    exec("rm ../administrator/cookie/*");
    header("Location: /administrator/index.html");
    exit();
  }
  else{
    if (!file_exists("../administrator/cookie/" . $_COOKIE['admin'])){
        header("Location:/administrator/index.html");
        exit();
    }
  }
  check_phid($_COOKIE['admin']);
//$fh = fopen('qrid.txt','r');
//$qrid = fgets($fh);
function check_string($pid){
  if (is_numeric($pid)){
  }
  else{
    echo("Invalid phid cookie!");
    
    exit();
  }
}
include "../usr_pre_fls/mk_mass.php";
$qrid = $_GET['page'];
$date = date(DATE_ATOM);
//fairly simple check if the user has entered the room number log it put it in the qrid folder and send it back to stupid
if (isset($_POST['rnum'])) {
  echo($_POST['rnum']);
  if ($_POST['rnum'] == ""){
    if (!file_exists("../registerd_qrids/" . $qrid)){
      //exec("cd registerd_qrids/ && echo '{$rnum}' >> {$qrid}");
      //NOTE: Dont ask me why its called stupid.php im still learning PHP and that was not easy to write
      header("Location: /mk_room/ck_qrid.php?page=" . $qrid);
      exit();
      } else{
          echo("QRID already set please try again");
          exit();
      }
    }
    $rnum=$_POST['rnum'];
    if (!file_exists("../teacher/student.php")){
      copy("../usr_pre_fls/index_teacher.php", "../teacher/student.php");
    }
    $rnum=$_POST['rnum'];
    $student_teacher = ('<?php if ($_POST["room"] == ' . $rnum . '){header("Location: /human_info/teacher_portal/' . $qrid . '.php");}?>');
  $student = file_put_contents('../teacher/student.php/', $student_teacher.PHP_EOL , FILE_APPEND | LOCK_EX);
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
    if (!file_exists("../registerd_qrids/" . $qrid)){
    $room = fopen("../registerd_qrids/" . $qrid, "w");
    check_string($rnum);
    room($qrid, "../../mass.json");
    fwrite($room, $rnum);
    if (!is_file("../human_info/teacher_portal/" . $qrid . ".php")){
      copy("../usr_pre_fls/index_teacher_other.php", "../human_info/teacher_portal/" . $qrid . ".php");
    }
    //exec("cd registerd_qrids/ && echo '{$rnum}' >> {$qrid}");
    //NOTE: Dont ask me why its called stupid.php im still learning PHP and that was not easy to write
    header("Location: /mk_room/ck_qrid.php?page=" . $qrid);
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