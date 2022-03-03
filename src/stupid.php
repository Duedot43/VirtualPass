<?php
$cookie_name = "phid";
//$qrid=$_POST['qrid'];
$fh = fopen('qrid.txt','r');
$qrid = fgets($fh);
$output = exec("tree -i --noreport registerd_qrids/ | grep -o {$qrid}");
if($output != $qrid) {
    header("Location: /regqrid.html");
    exit();
} 
if(!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
    header("Location: /register.html");
    exit();
  } else {
    
    //echo "Cookie '" . $cookie_name . "' is set!<br>";
    //echo "Value is: " . $_COOKIE[$cookie_name];
    $catin = exec("ls departed/ | grep " . $_COOKIE[$cookie_name]);
    $catout = exec("ls registered_phid/ | grep " . $_COOKIE[$cookie_name]);
    //echo ("Hall pass registerd<br>");
    //echo ("Please rescan the QR code if this is your first time.<br>");
    //echo " out ", $catout, " in ", $catin, " cookie ", $_COOKIE[$cookie_name];
    //1 = departed
    $cook = ("0");
    if ($catout == $_COOKIE[$cookie_name]) {
      $fh = fopen('registered_phid/' . $_COOKIE[$cookie_name],'r');
      $cookid = fgets($fh); 
      $dpt = ("Departed");
      $cook = ("1");
      exec("mv -v registered_phid/" . $_COOKIE[$cookie_name] . " departed/");
    }
    if ($catin == $_COOKIE[$cookie_name]) {
      $fh = fopen('departed/' . $_COOKIE[$cookie_name],'r');
      $cookid = fgets($fh); 
      $dpt = ("Arrived");
      $cook = ("1");
      exec("mv -v departed/" . $_COOKIE[$cookie_name] . " registered_phid/");
    }
    if ($cook == "0") {
      //cookie error re register cookie and delete the cookie
      setcookie("phid", "", time() - 9999999999);
      header("Location: /register.html");
    }
    $date = exec("date");
    if ($dpt == "Arrived"){
      $dpt2 = ("Depart");
    }
    if ($dpt == "Departed"){
      $dpt2 = ("Arrive");
    }
    //echo("you have {$dpt}<br>");
    exec("echo ///////////////////////////////////////////////// >> log/inout.log");
    exec("echo '{$date}' >> log/inout.log");
    //echo($cookid);
    exec("echo '{$cookid}' >> log/inout.log");
    $rid = exec("cat registerd_qrids/{$qrid}");
    exec("echo '{$dpt}' '{$rid}' >> log/inout.log");
    exec("echo ///////////////////////////////////////////////// >> log/inout.log");

  }
//change Arrive/daparted button to show what it is going to do ,done
//HOW TO APPLE USE THE CODE BELOW FOR HTML KEEP THE PHP THINGS THOSE ARE THE VARIABLES TO DISPLAY//
?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<tr>
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td colspan="3"><strong>Hall pass registerd<br>you have <?php echo $dpt;?><br></strong></td>
</tr>
<tr>
<td width="0"></td>
<td width="0"></td>
<td width="294"><input class="reg" type="button" value='<?php echo $dpt2;?>' onclick="location='stupid.php'" /></td>
<td width="78"></td>
<td width="80"></td>
<td width="294"><input class="reg" type="button" value="Delete User Info" onclick="location='delusrpmt.php'" style="border-color:red; color:white"/></td>
<td width="0"></td>
<td width="0"></td>
</tr>
<tr>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
