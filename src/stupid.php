<?php
$cookie_name = "phid";
//$qrid=$_POST['qrid'];
//$fh = fopen('qrid.txt','r');
//$qrid = fgets($fh);
$qrid = $_GET['page'];
//echo $qrid;
$output = exec("tree -i --noreport registerd_qrids/ | grep -o {$qrid}");
if($output != $qrid) {
    header("Location: /regqrid.php?page=" . $qrid);
    exit();
} 
if(!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
    header("Location: /registercookie.php?page=" . $qrid);
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
      $fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/' . $_COOKIE[$cookie_name],'r');
      $cookid = fgets($fh); 
      $dpt = ("Departed");
      $cook = ("1");
      exec("mv -v registered_phid/" . $_COOKIE[$cookie_name] . " departed/");
    }
    if ($catin == $_COOKIE[$cookie_name]) {
      $fh = fopen('departed/' . $_COOKIE[$cookie_name] . '/' . $_COOKIE[$cookie_name],'r');
      $cookid = fgets($fh); 
      $dpt = ("Arrived");
      $cook = ("1");
      exec("mv -v departed/" . $_COOKIE[$cookie_name] . " registered_phid/");
    }
    if ($cook == "0") {
      //cookie error re register cookie and delete the cookie
      setcookie("phid", "", time() - 9999999999);
      header("Location: /registercookie.php?page=" . $qrid);
    }
    exec("echo {$cook}");
    $date = exec("date");
    if ($dpt == "Arrived"){
      $dpt2 = ("Depart");
    }
    if ($dpt == "Departed"){
      $dpt2 = ("Arrive");
    }
    //echo("you have {$dpt}<br>");
    $dayofmonth = exec("date +'%d'");
    $hour = exec("date +'%H'");
    $minute = exec("date +'%M'");
    $ariveis = exec("cd registered_phid/" . $_COOKIE[$cookie_name] . "/srvinfo && ls hour_gon");
    $ariveis1 = exec("cd departed/" . $_COOKIE[$cookie_name] . "/srvinfo && ls hour_gon");
    if ($ariveis != "hour_gon"){
      exec("cd registered_phid/" . $_COOKIE[$cookie_name] . "/srvinfo && echo '{$dayofmonth}' >> 'dayofmonth_gon' && echo '{$hour}' >> 'hour_gon' && echo '{$minute}' >> 'minute_gon'");
    }
    if ($ariveis == "hour_gon"){
      exec("cd registered_phid/" . $_COOKIE[$cookie_name] . "/srvinfo && echo '{$dayofmonth}' >> 'dayofmonth_arv' && echo '{$hour}' >> 'hour_arv' && echo '{$minute}' >> 'minute_arv'");
    }
    if ($ariveis1 != "hour_gon"){
      exec("cd departed/" . $_COOKIE[$cookie_name] . "/srvinfo && echo '{$dayofmonth}' >> 'dayofmonth_gon' && echo '{$hour}' >> 'hour_gon' && echo '{$minute}' >> 'minute_gon'");
    }
    if ($ariveis1 == "hour_gon"){
      exec("cd departed/" . $_COOKIE[$cookie_name] . "/srvinfo && echo '{$dayofmonth}' >> 'dayofmonth_arv' && echo '{$hour}' >> 'hour_arv' && echo '{$minute}' >> 'minute_arv'");
    }
    $ariveis_verify_reg_gon = exec("cd registered_phid/" . $_COOKIE[$cookie_name] . "/srvinfo && ls hour_gon");
    $ariveis_verify_reg_arv = exec("cd registered_phid/" . $_COOKIE[$cookie_name] . "/srvinfo && ls hour_arv");
    //$ariveis_dep_reg_gon = exec("cd departed/" . $_COOKIE[$cookie_name] . "/srvinfo && ls hour_gon");
    //$ariveis_dep_reg_arv = exec("cd departed/" . $_COOKIE[$cookie_name] . "/srvinfo && ls hour_arv");
    if ($ariveis_verify_reg_gon == "hour_gon"){
      if ($ariveis_verify_reg_arv == "hour_arv"){
        $fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo/dayofmonth_gon','r');
        $dayofmonth_gon = fgets($fh);
        $fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo/dayofmonth_arv','r');
        $dayofmonth_arv = fgets($fh);
        $fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo/hour_gon','r');
        $hour_gon = fgets($fh);
        $fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo/hour_arv','r');
        $hour_arv = fgets($fh);
        $fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo/minute_gon','r');
        $minute_gon = fgets($fh);
        $fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo/minute_arv','r');
        $minute_arv = fgets($fh);
        $fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . "/" . $_COOKIE[$cookie_name],'r');
        $usrinfo = fgets($fh);
        $days_gone = $dayofmonth_arv-$dayofmonth_gon;
        $hours_gone = $hour_arv-$hour_gon;
        $minutes_gone = $minute_arv-$minute_gon;
        $current_date = exec("date +'%F'");
        $current_hour = exec("date +'%H'");
        $rid1 = exec("cat registerd_qrids/{$qrid}");
        session_start();
        $cookieodd = $_COOKIE[$cookie_name];
        //$ckdatehtml = exec("cd registered_phid/" . $cookieodd . "/huinfo/ && ls ./" . $current_date);
        if (!is_dir("registered_phid/" . $cookieodd . "/huinfo/" . $current_date)){
          exec("mkdir registered_phid/" . $_COOKIE[$cookie_name] . "/huinfo/" . $current_date . "/");
          exec('cd registered_phid/' . $_COOKIE[$cookie_name] . '/huinfo/ && echo "<"link href="/style.css" rel="stylesheet" type="text/css" "/>""<"input type="button" value=\'Date:' . $current_date . '\' onclick="location=\'/registered_phid/' . $_COOKIE[$cookie_name] . '/huinfo/' . $current_date . '/index.html\'" "/><br>" >> index.html');
        }
        
        
        //exec("cd registered_phid/" . $_COOKIE[$cookie_name] . "/huinfo/" . $current_date . "/" . $rid1 . "/");
        
        //$ckroomhtml = exec("cd registered_phid/" . $cookieodd . "/huinfo/" . $current_date . "/ && ls ./" . $rid1);
        if (!is_dir("registered_phid/" . $_COOKIE[$cookie_name] . "/huinfo/" . $current_date . "/" . $rid1)){
          exec("mkdir registered_phid/" . $_COOKIE[$cookie_name] . "/huinfo/" . $current_date . "/" . $rid1 . "/");
          exec('cd registered_phid/' . $_COOKIE[$cookie_name] . '/huinfo/' . $current_date . '/ && echo "<"link href="/style.css" rel="stylesheet" type="text/css" "/>""<"input type="button" value="Room:' . $rid1 . '" onclick="location=\'/registered_phid/' . $_COOKIE[$cookie_name] . '/huinfo/' . $current_date . '/' . $rid1 . '/index.html\'" "/><br>" >> index.html');
        }
        
        exec('cd registered_phid/' . $_COOKIE[$cookie_name] . '/huinfo/' . $current_date . '/' . $rid1 . '/ && echo "<"link href="/style.css" rel="stylesheet" type="text/css" "/>""<"input type="button" value="Hour:' . $current_hour . '" onclick="location=\'/registered_phid/' . $_COOKIE[$cookie_name] . '/huinfo/' . $current_date . '/' . $rid1 . '/' . $current_hour . '.html\'" "/><br>" >> index.html');
        exec("cd registered_phid/" . $_COOKIE[$cookie_name] . "/huinfo/" . $current_date . "/" . $rid1 . "/ && echo '<'link href='/style.css' rel='stylesheet' type='text/css' '/>''" . $usrinfo . "' was out for '" . $days_gone . "' days '" . $hours_gone . "' hours and '" . $minutes_gone . "' minutes.'<br>'Student left classroom '" . $rid1 . "' at '" . $hour_gon . "':'" . $minute_gon . "' and arrived at '" . $hour_arv . "':'" . $minute_arv . "<br>' >> '" . $current_hour . "'.html");
        exec('cd registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo && rm ./*');
        session_destroy();
      }
    }

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
<title><?php echo $dpt;?></title>
<tr>
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td colspan="3"><strong>Hall pass registerd<br>you have <?php echo $dpt;?><br></strong></td>
</tr>
<tr>
<td width="0"></td>
<td width="0"></td>
<td width="294"><input class="reg" type="button" value='<?php echo $dpt2;?>' onclick="location='stupid.php?page=<?php echo $qrid;?>'" /></td>
<td width="78"></td>
<td width="80"></td>
<td width="294"><input class="reg" type="button" value="Delete User Info" onclick="location='delusrpmt.php?page=<?php echo $qrid;?>'" style="border-color:red; color:white"/></td>
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
