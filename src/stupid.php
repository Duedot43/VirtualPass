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
function check_qrid($pid){
  if (is_numeric($pid)){
  }
  else{
      echo("Invalid! not numeric");
    
    exit();
  }
}
function check_phid($pid){
  if (is_numeric($pid)){
  }
  else{
    echo("Invalid phid cookie!");
    
    exit();
  }
}
$ini = parse_ini_file('../config/config.ini');
if ($ini['overide_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['overide_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
$cookie_name = "phid";
if (isset($_GET['page'])){
  if ($_GET['page'] == ""){
    echo("No page value!");
    exit();
  }
} else{echo("No page value!");exit();}
//get the page value in the link and pass it on
$qrid = $_GET['page'];
if(!file_exists("registerd_qrids/" . $qrid)) {
  //if it is not found make it with regqrid and pass page on
    header("Location: /regqrid.php?page=" . $qrid);
    exit();
} 
//check is the cookie is set or not
if(!isset($_COOKIE[$cookie_name])) {
  //if its not register it along with the cookie
    header("Location: /registercookie.php?page=" . $qrid);
    exit();
  } else {
    check_phid($_COOKIE[$cookie_name]);
    $cook = ("0");
    if (file_exists("registered_phid/" . $_COOKIE[$cookie_name])) {
      //the user is not departed do read the file and move them to the departed folder
      $fh = parse_ini_file('registered_phid/' . $_COOKIE[$cookie_name]);

      if ($fh['student_activity'] == "Arrived"){
        
        config_set('registered_phid/' . $_COOKIE[$cookie_name], "usrinfo", "student_activity", "Departed");
      } else{
        
        config_set('registered_phid/' . $_COOKIE[$cookie_name], "usrinfo", "student_activity", "Arrived");
      }
      $fh = parse_ini_file('registered_phid/' . $_COOKIE[$cookie_name]);
      $dpt = ($fh['student_activity']);
      $cook = ("1");
    }
    if (!file_exists("registered_phid/" . $_COOKIE[$cookie_name])){
      setcookie($cookie_name, "", time() - (86400 * 360), "/", $domain, TRUE, TRUE);
      header("Location: /registercookie.php?page=" . $qrid);
      exit();
    }
      //read the file and mark them as arrived

      $user_ini = parse_ini_file("registered_phid/" . $_COOKIE[$cookie_name]);
      if (!isset($user_ini[$qrid])){
        $add_to_file = $qrid . "=" . $qrid . "\n";
        file_put_contents("registered_phid/" . $_COOKIE[$cookie_name], $add_to_file.PHP_EOL , FILE_APPEND | LOCK_EX);
      }
    //checking if the cookie is registered but they are not in the files
    if ($cook == "0") {
      //cookie error re register cookie and delete the cookie
      setcookie($cookie_name, "", time() - (86400 * 360), "/", $domain, TRUE, TRUE);
      header("Location: /registercookie.php?page=" . $qrid);
    }

    $date = date(DATE_ATOM);
    if ($dpt == "Arrived"){
      $dpt2 = ("Depart");
    }
    if ($dpt == "Departed"){
      $dpt2 = ("Arrive");
    }
    $a = getdate();
    $dayofmonth = $a['mday'];
    $hour = $a['hours'];
    $minute = $a['minutes'];
    //check if hour_gon exiests to check the user time later
    $ini = parse_ini_file("registered_phid/" . $_COOKIE[$cookie_name]);
    // change this to see when the user has departed/arrived
    if ($ini['hour_gon'] == ""){
      
      config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "dayofmonth_gon", $dayofmonth);
      
      config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "hour_gon", $hour);
      
      config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "minute_gon", $minute);
      
    } else{
      
      config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "dayofmonth_arv", $dayofmonth);
      
      config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "hour_arv", $hour);
      
      config_set('registered_phid/' . $_COOKIE[$cookie_name], "srvinfo", "minute_arv", $minute);
      
    }
    
    $ini = parse_ini_file("registered_phid/" . $_COOKIE[$cookie_name]);
    if ($ini['hour_gon'] != ""){
      if ($ini['hour_arv'] != ""){
        
        $ini = parse_ini_file("registered_phid/" . $_COOKIE[$cookie_name]);
        $cookid = $ini['first_name'] . " " . $ini['last_name'] . " " . $ini['student_id'] . " " . $ini['student_email'];
        $dayofmonth_gon = $ini['dayofmonth_gon'];
        $dayofmonth_arv = $ini['dayofmonth_arv'];
        $hour_gon = $ini['hour_gon'];
        $hour_arv = $ini['hour_arv'];
        $minute_gon = $ini['minute_gon'];
        $minute_arv = $ini['minute_arv'];
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
        fclose($rid31);
        //get the room ID
        session_start();
        $cookieodd = $_COOKIE[$cookie_name];
        //check if current date exiests if it does dont make a DIR and dont add it to the html file
        $ini = parse_ini_file("registered_phid/" . $_COOKIE[$cookie_name]);
        if (!is_dir("human_info/" . $cookieodd . "/" . $current_date)){
          
          mkdir("human_info/" . $_COOKIE[$cookie_name] . "/" . $current_date);
          //make a button for the current day for the admin log
          $main_html = '<link href="/style.css" rel="stylesheet" type="text/css" /><input class="reg" type="button" value="' . $current_date . '" onclick="location=\'/human_info/' . $_COOKIE[$cookie_name] . '/' . $current_date . '/index.html\'" /></td>';
          $student = file_put_contents('human_info/' . $_COOKIE[$cookie_name] . '/index.html', $main_html.PHP_EOL , FILE_APPEND | LOCK_EX);
        }
        
        
        
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
        $guide_to_info_page = '<link href="/style.css" rel="stylesheet" type="text/css" /><input class="reg" type="button" value="Hour: ' . $current_hour . '" onclick="location=\'/human_info/' . $_COOKIE[$cookie_name] . '/' . $current_date . '/' . $rid1 . '/' . $current_hour . '.html\'" /></td>';
        $student = file_put_contents('human_info/' . $_COOKIE[$cookie_name] . '/' . $current_date . '/' . $rid1 . '/index.html', $guide_to_info_page.PHP_EOL , FILE_APPEND | LOCK_EX);
      }
        $info_page = '<link href="/style.css" rel="stylesheet" type="text/css" />' . $usrinfo . ' was out for ' . $days_gone . ' days ' . $hours_gone . ' hours and ' . $minutes_gone . ' minutes.<br>Student left classroom ' . $rid1 . ' at ' . $hour_gon . ':' . $minute_gon . ' and arrived at ' . $hour_arv . ':' . $minute_arv . '<br>';
        $student = file_put_contents("human_info/" . $_COOKIE[$cookie_name] . "/" . $current_date . "/" . $rid1 . "/" . $current_hour . ".html", $info_page.PHP_EOL , FILE_APPEND | LOCK_EX);
        //destroy all the variables for good mesure
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
<td width="294"><input class="reg" type="button" value="Delete User Info" onclick="location='delusrpmt.php?page=<?php echo $qrid;?>'" style="border-color:97042F; color:white"/></td>
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
