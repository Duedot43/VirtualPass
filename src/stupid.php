<?php
//nooooo this code is not stolen fron StackOverflow no never!
function config_set($config_file, $section, $key, $value) {
  $config_data = parse_ini_file($config_file, true);
  $config_data[$section][$key] = $value;
  $new_content = '';
  foreach ($config_data as $section => $section_content) {
      $section_content = array_map(function($value, $key) {
          return "$key=$value";
      }, array_values($section_content), array_keys($section_content));
      $section_content = implode("\n", $section_content);
      $new_content .= "[$section]\n$section_content\n";
  }
  file_put_contents($config_file, $new_content);
}
//nooooo this code is not stolen fron StackOverflow no never!
function check_qrid($num){
  if (!filter_var($num, FILTER_VALIDATE_INT) === false) {
      echo("Valid");
  } else {
      echo("Invalid not an intiger");
      
      exit();
  }
}
function check_phid($pid){
  if (is_numeric($pid)){
  }
  else{
    echo("Invalid!");
    
    exit();
  }
}
$cookie_name = "phid";
//$qrid=$_POST['qrid'];
//$fh = fopen('qrid.txt','r');
//$qrid = fgets($fh);
//get the page value in the link and pass it on
$qrid = $_GET['page'];
//echo $qrid;
//look for the qrid in the files
//$output = exec("tree -i --noreport registerd_qrids/ | grep -o {$qrid}");
if(!file_exists("registerd_qrids/" . $qrid)) {
  //if it is not found make it with regqrid and pass page on
    header("Location: /regqrid.php?page=" . $qrid);
    exit();
} 
//check is the cookie is set or not
if(!isset($_COOKIE[$cookie_name])) {
  //if its not register it along with the cookie
    echo "Cookie named '" . $cookie_name . "' is not set!";
    header("Location: /registercookie.php?page=" . $qrid);
    exit();
  } else {
    check_phid($_COOKIE[$cookie_name]);
    //echo "Cookie '" . $cookie_name . "' is set!<br>";
    //echo "Value is: " . $_COOKIE[$cookie_name];
    //look for the user in the files and find out if they are departed or not
    //$catin = exec("ls departed/ | grep " . $_COOKIE[$cookie_name]);
    //$catout = exec("ls registered_phid/ | grep " . $_COOKIE[$cookie_name]);
    //echo ("Hall pass registerd<br>");
    //echo ("Please rescan the QR code if this is your first time.<br>");
    //echo " out ", $catout, " in ", $catin, " cookie ", $_COOKIE[$cookie_name];
    //1 = departed
    $cook = ("0");
    if (file_exists("registered_phid/" . $_COOKIE[$cookie_name])) {
      //the user is not departed do read the file and move them to the departed folder
      $fh = parse_ini_file('registered_phid/' . $_COOKIE[$cookie_name]);
      //$cookid = fgets($fh); 
      //$dpt = ($ini['']);
      if ($fh['student_activity'] == "Arrived"){
        
        config_set('registered_phid/' . $_COOKIE[$cookie_name], "usrinfo", "student_activity", "Departed");
      } else{
        
        config_set('registered_phid/' . $_COOKIE[$cookie_name], "usrinfo", "student_activity", "Arrived");
      }
      $fh = parse_ini_file('registered_phid/' . $_COOKIE[$cookie_name]);
      $dpt = ($fh['student_activity']);
      $cook = ("1");
      //exec("mv -v registered_phid/" . $_COOKIE[$cookie_name] . " departed/");
    }
    //if the top if statment has triggered this one will not beacuse $catout is outdated at this point
    //if the user is found in departed the below if triggers
    //if ($catin == $_COOKIE[$cookie_name]) {
    //  $fh = fopen('departed/' . $_COOKIE[$cookie_name] . '/' . $_COOKIE[$cookie_name],'r');
    //  $cookid = fgets($fh); 
      //read the file and mark them as arrived
    //  $dpt = ("Arrived");
    //  $cook = ("1");
    //  exec("mv -v departed/" . $_COOKIE[$cookie_name] . " registered_phid/");
      //move them to the arrived folder
   // }
    //checking if the cookie is registered but they are not in the files
    if ($cook == "0") {
      //cookie error re register cookie and delete the cookie
      setcookie($cookie_name, "", time() - (86400 * 360), "/", $domain, TRUE, TRUE);
      header("Location: /registercookie.php?page=" . $qrid);
    }
    //exec("echo {$cook}");
    //$dpt2 is for the webpage title and the button
    $date = date(DATE_ATOM);
    if ($dpt == "Arrived"){
      $dpt2 = ("Depart");
    }
    if ($dpt == "Departed"){
      $dpt2 = ("Arrive");
    }
    //echo("you have {$dpt}<br>");
    //get the current time and date and set the variables
    $a = getdate();
    $dayofmonth = $a['mday'];
    $hour = $a['hours'];
    $minute = $a['minutes'];
    //check if hour_gon exiests to check the user time later
    //$ariveis = exec("cd registered_phid/" . $_COOKIE[$cookie_name] . "/srvinfo && ls hour_gon");
    //$ariveis1 = exec("cd departed/" . $_COOKIE[$cookie_name] . "/srvinfo && ls hour_gon");
    $ini = parse_ini_file("registered_phid/" . $_COOKIE[$cookie_name]);
    if ($ini['hour_gon'] == ""){
      
      config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "dayofmonth_gon", $dayofmonth);
      
      config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "hour_gon", $hour);
      
      config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "minute_gon", $minute);
      
    } else{
      
      config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "dayofmonth_arv", $dayofmonth);
      
      config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "hour_arv", $hour);
      
      config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "minute_arv", $minute);
      
    }
    //if ($ariveis1 != "hour_gon"){
      //exec("cd departed/" . $_COOKIE[$cookie_name] . "/srvinfo && echo '{$dayofmonth}' >> 'dayofmonth_gon' && echo '{$hour}' >> 'hour_gon' && echo '{$minute}' >> 'minute_gon'");
    //}
    //if ($ariveis1 == "hour_gon"){
      //exec("cd departed/" . $_COOKIE[$cookie_name] . "/srvinfo && echo '{$dayofmonth}' >> 'dayofmonth_arv' && echo '{$hour}' >> 'hour_arv' && echo '{$minute}' >> 'minute_arv'");
    //}
    //check if hour_gon and hour_arrive exiest
    //$ariveis_verify_reg_gon = exec("cd registered_phid/" . $_COOKIE[$cookie_name] . "/srvinfo && ls hour_gon");
    //$ariveis_verify_reg_arv = exec("cd registered_phid/" . $_COOKIE[$cookie_name] . "/srvinfo && ls hour_arv");
    //$ariveis_dep_reg_gon = exec("cd departed/" . $_COOKIE[$cookie_name] . "/srvinfo && ls hour_gon");
    //$ariveis_dep_reg_arv = exec("cd departed/" . $_COOKIE[$cookie_name] . "/srvinfo && ls hour_arv");
    
    $ini = parse_ini_file("registered_phid/" . $_COOKIE[$cookie_name]);
    if ($ini['hour_gon'] != ""){
      if ($ini['hour_arv'] != ""){
        
        $ini = parse_ini_file("registered_phid/" . $_COOKIE[$cookie_name]);
        $cookid = $ini['first_name'] . " " . $ini['last_name'] . " " . $ini['student_id'] . " " . $ini['student_email'];
        //$fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo/dayofmonth_gon','r');
        $dayofmonth_gon = $ini['dayofmonth_gon'];
        //$fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo/dayofmonth_arv','r');
        $dayofmonth_arv = $ini['dayofmonth_arv'];
        //$fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo/hour_gon','r');
        $hour_gon = $ini['hour_gon'];
        //$fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo/hour_arv','r');
        $hour_arv = $ini['hour_arv'];
        //$fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo/minute_gon','r');
        $minute_gon = $ini['minute_gon'];
        //$fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo/minute_arv','r');
        $minute_arv = $ini['minute_arv'];
        //$fh = fopen('registered_phid/' . $_COOKIE[$cookie_name] . "/" . $_COOKIE[$cookie_name],'r');
        $usrinfo = $ini['first_name'] . " " . $ini['last_name'] . " " . $ini['student_id'] . " " . $ini['student_email'];
        //get all the time
        $days_gone = $dayofmonth_arv-$dayofmonth_gon;
        $hours_gone = $hour_arv-$hour_gon;
        $minutes_gone = $minute_arv-$minute_gon;
        //^^^^ see how long they were gone ^^^^
        $a = getdate();
        $current_date = date("Y") . "-" . date("n") . "-" . date("d");
        $current_hour = $a['hours'];
        $rid31 = fopen("registerd_qrids/" . $qrid, "r");
        $rid12 = fread($rid31, "30");
        $rid1 = str_replace(PHP_EOL, '', $rid12);
        //get the room ID
        session_start();
        $cookieodd = $_COOKIE[$cookie_name];
        //$ckdatehtml = exec("cd registered_phid/" . $cookieodd . "/huinfo/ && ls ./" . $current_date);
        //check if current date exiests if it does dont make a DIR and dont add it to the html file
        $ini = parse_ini_file("registered_phid/" . $_COOKIE[$cookie_name]);
        if (!is_dir("human_info/" . $cookieodd . "/" . $current_date)){
          
          mkdir("human_info/" . $_COOKIE[$cookie_name] . "/" . $current_date);
          //exec("mkdir registered_phid/" . $_COOKIE[$cookie_name] . "/huinfo/" . $current_date . "/");
          //make a button for the current day for the admin log
          $main_html = '<link href="/style.css" rel="stylesheet" type="text/css" /><input class="reg" type="button" value="' . $current_date . '" onclick="location=\'/human_info/' . $_COOKIE[$cookie_name] . '/' . $current_date . '/index.html\'" /></td>';
          $student = file_put_contents('human_info/' . $_COOKIE[$cookie_name] . '/index.html', $main_html.PHP_EOL , FILE_APPEND | LOCK_EX);
          //exec('cd registered_phid/' . $_COOKIE[$cookie_name] . '/huinfo/ && echo <link href="/style.css" rel="stylesheet" type="text/css" /><input type="button" value=\'Date:' . $current_date . '\' onclick="location=\'/registered_phid/' . $_COOKIE[$cookie_name] . '/huinfo/' . $current_date . '/index.html\'" "/><br>" >> index.html');
        }
        
        
        //exec("cd registered_phid/" . $_COOKIE[$cookie_name] . "/huinfo/" . $current_date . "/" . $rid1 . "/");
        
        //$ckroomhtml = exec("cd registered_phid/" . $cookieodd . "/huinfo/" . $current_date . "/ && ls ./" . $rid1);
        //check if the room exiests if it does do not add it to the HTML file and do not make the DIR
        if (!is_dir("human_info/" . $_COOKIE[$cookie_name] . "/" . $current_date . "/" . $rid1)){
          //if so make the dir and add it to the HTML file
          mkdir("human_info/" . $_COOKIE[$cookie_name] . "/" . $current_date . "/" . $rid1);
          $current_date_html = '<link href="/style.css" rel="stylesheet" type="text/css" /><input class="reg" type="button" value="' . $rid1 . '" onclick="location=\'/human_info/' . $_COOKIE[$cookie_name] . '/' . $current_date . '/' . $rid1 . '/index.html\'" /></td>';
          $student = file_put_contents('human_info/' . $_COOKIE[$cookie_name] . '/' . $current_date . '/index.html', $current_date_html.PHP_EOL , FILE_APPEND | LOCK_EX);
        }
        //i always need to add the hour to the html file this is assuming people dont go to the restroom every .2 seconds 
        //OH MY GOD WHY DO PEOPLE DO TO THE BATHROOM EVERY .5 SECONDS AHHHH
        //And im too lazy to add another thing above and convert the backend lol NOOOOOO
        if (!is_file("human_info/" . $_COOKIE[$cookie_name] . "/" . $current_date . "/" . $rid1 . "/" . $current_hour . ".html")){
          //exec($current_hour . ".html does exiest");
        $guide_to_info_page = '<link href="/style.css" rel="stylesheet" type="text/css" /><input class="reg" type="button" value="Hour: ' . $current_hour . '" onclick="location=\'/human_info/' . $_COOKIE[$cookie_name] . '/' . $current_date . '/' . $rid1 . '/' . $current_hour . '.html\'" /></td>';
        $student = file_put_contents('human_info/' . $_COOKIE[$cookie_name] . '/' . $current_date . '/' . $rid1 . '/index.html', $guide_to_info_page.PHP_EOL , FILE_APPEND | LOCK_EX);
      }
        //exec('cd registered_phid/' . $_COOKIE[$cookie_name] . '/huinfo/' . $current_date . '/' . $rid1 . '/ && echo "<"link href="/style.css" rel="stylesheet" type="text/css" "/>""<"input type="button" value="Hour:' . $current_hour . '" onclick="location=\'/registered_phid/' . $_COOKIE[$cookie_name] . '/huinfo/' . $current_date . '/' . $rid1 . '/' . $current_hour . '.html\'" "/><br>" >> index.html');
        $info_page = '<link href="/style.css" rel="stylesheet" type="text/css" />' . $usrinfo . ' was out for ' . $days_gone . ' days ' . $hours_gone . ' hours and ' . $minutes_gone . ' minutes.<br>Student left classroom ' . $rid1 . ' at ' . $hour_gon . ':' . $minute_gon . ' and arrived at ' . $hour_arv . ':' . $minute_arv . '<br>';
        $student = file_put_contents("human_info/" . $_COOKIE[$cookie_name] . "/" . $current_date . "/" . $rid1 . "/" . $current_hour . ".html", $info_page.PHP_EOL , FILE_APPEND | LOCK_EX);
        //exec("cd registered_phid/" . $_COOKIE[$cookie_name] . "/huinfo/" . $current_date . "/" . $rid1 . "/ && echo '<'link href='/style.css' rel='stylesheet' type='text/css' '/>''" . $usrinfo . "' was out for '" . $days_gone . "' days '" . $hours_gone . "' hours and '" . $minutes_gone . "' minutes.'<br>'Student left classroom '" . $rid1 . "' at '" . $hour_gon . "':'" . $minute_gon . "' and arrived at '" . $hour_arv . "':'" . $minute_arv . "<br>' >> '" . $current_hour . "'.html");
        //destroy all the variables for good mesure
        //exec('cd registered_phid/' . $_COOKIE[$cookie_name] . '/srvinfo && rm ./*');
        config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "dayofmonth_gon", "");
        config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "hour_gon", "");
        config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "minute_gon", "");
        config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "dayofmonth_arv", "");
        config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "hour_arv", "");
        config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "minute_arv", "");
        session_destroy();
      }
    }
//record it in the blob log haha that rymes
$inithing = parse_ini_file("../config/config.ini");
if ($inithing['enable_insecure_general_logs'] == "1"){
    exec("echo ///////////////////////////////////////////////// >> log/inout.log");
    exec("echo '{$date}' >> log/inout.log");
    //echo($cookid);
    exec("echo '{$cookid}' >> log/inout.log");
    $rid = exec("cat registerd_qrids/{$qrid}");
    exec("echo '{$dpt}' '{$rid}' >> log/inout.log");
    exec("echo ///////////////////////////////////////////////// >> log/inout.log");
}

  }
//change Arrive/daparted button to show what it is going to do ,done
//All how to apples code that i have no idea how it works but hey it looks good
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
<td colspan="80"><strong>Hall pass registered<br>you have <?php echo $dpt;?><br></strong></td>
</tr>
<tr>
<td width="0"></td>
<td width="0"></td>
<td width="294"><input class="reg" type="button" id="return" value='<?php echo $dpt2;?>' onclick="location='stupid.php?page=<?php echo $qrid;?>'" /></td>
<script>
document.getElementById("return").disabled = true;
document.querySelector('#return').value = '5';
setTimeout(() => { document.querySelector('#return').value = '4'; }, 1000);
setTimeout(() => { document.querySelector('#return').value = '3'; }, 2000);
setTimeout(() => { document.querySelector('#return').value = '2'; }, 3000);
setTimeout(() => { document.querySelector('#return').value = '1'; }, 4000);
setTimeout(() => {  document.getElementById("return").disabled = false; }, 5000);
setTimeout(() => { document.querySelector('#return').value = '<?php echo $dpt2;?>'; }, 5000);
</script>
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
