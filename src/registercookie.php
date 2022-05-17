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
function check_string($pid){
  if (is_numeric($pid)){
  }
  else{
      echo("Invalid! not numeric");
    
    exit();
  }
}
function check_name($num){
  if (ctype_alpha($num)) {
      echo("Valid");
  } else {
      echo("Invalid name");
      exit();
  }
}
$cookie_name = "phid";
include "usr_pre_fls/mk_mass.php";
//check for all the variables from the html below
$ini = parse_ini_file('../config/config.ini');
if ($ini['overide_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['overide_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
if (isset($_GET['page'])){
  if ($_GET['page'] == ""){
    echo("No page value!");
    exit();
  }
} else{echo("No page value!");exit();}
if(isset($_GET['page'])) {
  if(isset($_POST['firstname'])) {
    if(isset($_POST['lastname'])) {
      if(isset($_POST['stid'])) {
        if(isset($_POST['stem'])) {
          setcookie($cookie_name, "", time() - (86400 * 360), "/", $domain, TRUE, TRUE);
          //set all the variables
          $qrid = $_GET['page'];
          check_string($qrid);
          $firstname=$_POST['firstname'];
          $lastname=$_POST['lastname'];
          $stid=$_POST['stid'];
          $stem=$_POST['stem'];
          //get a unique id for the user
          $ranid = rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand();
          $date = date(DATE_ATOM);
          if(!isset($_COOKIE[$cookie_name])) {
            //set the cookie with their random id so i can identify them later
            $ini = parse_ini_file('../config/config.ini');
            $sendemail = $ini['em_enable'];
              $money = "$";
              setcookie($cookie_name, $ranid, time() + (86400 * 360), "/", $domain, TRUE, TRUE);
                user($ranid, "../mass.json");
              $inifl = fopen("registered_phid/" . $ranid, "w");
              $tet = ("[usrinfo]\nfirst_name=" . $firstname . "\nlast_name=" . $lastname . "\nstudent_id=" . $stid . "\nstudent_email=" . $stem . "\nstudent_activity=Arrived\n[srvinfo]\ndayofmonth_gon=\nhour_gon=\nminute_gon=\ndayofmonth_arv=\nhour_arv=\nminute_arv=\n[room]\n");
              fwrite($inifl, $tet);
              fclose($inifl);
              mkdir("human_info/" . $ranid);
              if ($sendemail == "1"){
                $txt = ('<head><link href="https://rawcdn.githack.com/Duedot43/VirtualPass/82889bcf8bd24b0df4b99b1a59bef0699f370474/src/style.css" rel="stylesheet" type="text/css" /></head><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>VirtualPass sign-up confirmation</title><tr><td><table width="100%" border="0" cellpadding="3" cellspacing="1"><tr><td colspan="3"><strong>Congrats ' . $firstname . ', your info has been set!<br>Choose any option below and it will redirect you to the VirtualPass website.<br></strong></td></tr><tr><td width="0"></td><td width="0"></td><td width="294"><input class="reg" type="button" value="Change user info" onclick="location=\'https://' . $domain . '/cgusr.php?user=' . $ranid . '\'" /></td><td width="78"></td><td width="80"></td><td width="294"><input class="reg" type="button" value="Delete User Info" onclick="location=\'https://' . $domain . '/delusreml.php?user=' . $ranid . '\'" style="border-color:red; color:white"/></td><td width="0"></td><td width="0"></td></tr><tr></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr></table>');
                $inifl = fopen("human_info/" . $ranid . "/email.html", "w");
                fwrite($inifl, $txt);
                fclose($inifl);
                if (file_exists("usr_pre_fls/email.php")){
                  $mail_json = json_decode(file_get_contents("../config/mail.json") ,true);
                  include "usr_pre_fls/email.php";
                  send($mail_json['email_email'], $mail_json['email_passwd'], $stem, $mail_json['email_username'], "human_info/" . $ranid . "/email.html", $mail_json['server'], $mail_json['server_port']);
                }

              }
              
              $user_ini = parse_ini_file("registered_phid/" . $ranid);
              if (!isset($user_ini[$qrid])){
                $add_to_file = $qrid . "=" . $qrid . "\n";
                file_put_contents("registered_phid/" . $ranid, $add_to_file.PHP_EOL , FILE_APPEND | LOCK_EX);
              }
              //send it back to stupid

              header("Location: /stupid.php?page=" . $qrid);
              exit();
          }
          if(isset($_COOKIE[$cookie_name])) {
    
            $cook = ("0");
            if (file_exists("registered_phid/" . $ranid)) {
              header("Location: /stupid.php?page=" . $qrid);
              $cook = ("1");
            }
            //if the top if statment has triggered this one will not beacuse $catout is outdated at this point
            //if the user is found in departed the below if triggers
            //checking if the cookie is registered but they are not in the files
            if ($cook == "0") {
              //cookie error re register cookie and delete the cookie
              setcookie($cookie_name, $ranid, time() - (86400 * 360), "/", $domain, TRUE, TRUE);
              header("Location: /stupid.php?page=" . $qrid);
            }
          }

        }
      }
    }
  }
}
?>

<title>Register Your User</title>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<tr>
    <form method="post">
        <td>
            <table width="100%" border="0" cellpadding="3" cellspacing="1">
                <tr>
                    <td colspan="3"><strong>Register! (you only have to do this once.) We do not collect data.
                            <hr />
                        </strong></td>
                </tr>
                <tr>
                    <td class="text" width="78">First Name
                        <td width="6">:</td>
                        <td width="294"><input class="box" autocomplete="off" name="firstname" type="text" pattern="[a-zA-Z]+" id="firstname"
                            required></td>
                    </td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td>:</td>
                    <td><input class="box" name="lastname" autocomplete="off" type="text" id="lastname" pattern="[a-zA-Z]+" required></td>
                </tr>
                <tr>
                    <td>Student ID</td>
                    <td>:</td>
                    <td><input class="box" name="stid" autocomplete="off" type="number" id="stid" placeholder="10150100" required></td>
                </tr>
                <td>Student E-Mail</td>
                <td>:</td>
                <td><input class="box" name="stem" autocomplete="off" type="email" id="stem" placeholder="student@cherrycreekschools.org"
                        required></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input class="reg" type="submit" name="Submit" value="Register"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>