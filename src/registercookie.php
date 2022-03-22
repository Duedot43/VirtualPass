<?php
$cookie_name = "phid";
//check for all the variables from the html below
$domain = $_SERVER['SERVER_NAME'];
//$domain = "1b0e-8-6-112-61.ngrok.io";
//echo $domain;
if(isset($_GET['page'])) {
  if(isset($_POST['firstname'])) {
    if(isset($_POST['lastname'])) {
      if(isset($_POST['stid'])) {
        if(isset($_POST['stem'])) {
          //set all the variables
          $qrid = $_GET['page'];
          $firstname=$_POST['firstname'];
          $lastname=$_POST['lastname'];
          $stid=$_POST['stid'];
          $stem=$_POST['stem'];
          //get a unique id for the user
          $ranid = uniqid(rand());
          echo $ranid;
          $date = exec("date");
          if(!isset($_COOKIE[$cookie_name])) {
            //set the cookie with their random id so i can identify them later
              $sendemail = exec("cat ../config/user_emails");
              $money = "$";
              setcookie($cookie_name, $ranid, time() + (86400 * 360), "/", $domain, TRUE);
              if(!isset($_COOKIE['phid'])) {
                echo("Hmm something has gone wrong I cant set your cookie. Trying fallback method...");
              }
              exec("cd registered_phid/ && mkdir '{$ranid}' && cd '{$ranid}' && mkdir 'srvinfo' && mkdir 'huinfo' && mkdir 'email' && echo '{$firstname}' '{$lastname}' '{$stid}' '{$stem}' >> '{$ranid}'");
              if ($sendemail == "1"){
                $myfile = fopen('registered_phid/' . $ranid . '/email/email.html', "w");

                $txt = ('<head><link href="https://rawcdn.githack.com/Duedot43/VirtualPass/82889bcf8bd24b0df4b99b1a59bef0699f370474/src/style.css" rel="stylesheet" type="text/css" /></head><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>VirtualPass sign-up confirmation</title><tr><td><table width="100%" border="0" cellpadding="3" cellspacing="1"><tr><td colspan="3"><strong>Congrats ' . $firstname . ', your info has been set!<br>Choose any option below and it will redirect you to the VirtualPass website.<br></strong></td></tr><tr><td width="0"></td><td width="0"></td><td width="294"><input class="reg" type="button" value="Change user info" onclick="location=\'https://' . $domain . '/cgusr.php?user=' . $ranid . '\'" /></td><td width="78"></td><td width="80"></td><td width="294"><input class="reg" type="button" value="Delete User Info" onclick="location=\'https://' . $domain . '/delusreml.php?user=' . $ranid . '\'" style="border-color:red; color:white"/></td><td width="0"></td><td width="0"></td></tr><tr></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table></td></tr></table>');
                fwrite($myfile, $txt);
                fclose($myfile);

              }
              if (!is_file("administrator/student.php")) {
                exec("cp usr_pre_fls/index.php ./administrator/student.php");
              }
              exec('cd administrator/ && echo "<"link href="/style.css" rel="stylesheet" type="text/css" "/>""<"input type="button" value="' . $firstname . '" onclick="location=\'/registered_phid/' . $ranid . '/huinfo/index.html\'" "/><br>" >> student.php');
              exec("echo ///////////////////////////////////////////////// >> log/inout.log");
              exec("echo '{$date}' >> log/inout.log");
              exec("echo '{$firstname}' registered with phid '{$ranid}' >> log/inout.log");
              exec("echo ///////////////////////////////////////////////// >> log/inout.log");
              //send it back to stupid
              header("Location: /stupid.php?page=" . $qrid);
              exit();
          }
              else {
                ////////SAME CODE IN STUPID.PHP////////
              
              //echo "Cookie '" . $cookie_name . "' is set!<br>";
              //echo "Value is: " . $_COOKIE[$cookie_name];
              $catine = exec("ls departed/ | grep " . $_COOKIE[$cookie_name]);
              $catoutee = exec("ls registered_phid/ | grep " . $_COOKIE[$cookie_name]);
              //echo ("Hall pass registerd<br>");
              //echo ("Please rescan the QR code if this is your first time.<br>");
              //echo " out ", $catout, " in ", $catin, " cookie ", $_COOKIE[$cookie_name];
              //1 = departed
              $cook = ("0");
              if ($catoutee == $_COOKIE[$cookie_name]) {
                //user already registered redirect
                header("Location: /stupid.php?page=" . $qrid);
                $cooki = ("1");
              }
              if ($catine == $_COOKIE[$cookie_name]) {
                //user already registered redirect
                header("Location: /stupid.php?page=" . $qrid);
                $cooki = ("1");
              }
              if ($cooki == "0") {
                //cookie error re register cookie and delete the cookie
                setcookie("phid", "", time() - 9999999999);
                header("Location: /registercookie.php?page=" . $qrid);
              }
          }
//setcookie($cookie_name, $ranid, time() + (86400 * 360));
//exec("cd registered_phid/ && echo '{$firstname}' '{$lastname}' '{$stid}' '{$stem}' >> {$ranid}");
//exec("echo '{$firstname} registered with phid {$ranid} >> log/inout.log");
//exec("echo ///////////////////////////////////////////////// >> log/inout.log");
//exec("echo '{$date}' >> log/inout.log");
//exec("echo '{$firstname} registered with phid {$ranid}' >> log/inout.log");
//exec("echo ///////////////////////////////////////////////// >> log/inout.log");
//header("Location: /stupid.php");

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