<?php
$cookie_name = "phid";
if(isset($_GET['page'])) {
  if(isset($_POST['firstname'])) {
    if(isset($_POST['lastname'])) {
      if(isset($_POST['stid'])) {
        if(isset($_POST['stem'])) {
          $qrid = $_GET['page'];
          $firstname=$_POST['firstname'];
          $lastname=$_POST['lastname'];
          $stid=$_POST['stid'];
          $stem=$_POST['stem'];
          $ranid = uniqid(rand());
          echo $ranid;
          $date = exec("date");
          if(!isset($_COOKIE[$cookie_name])) {
              setcookie($cookie_name, $ranid, time() + (86400 * 360));
              exec("cd registered_phid/ && echo '{$firstname}' '{$lastname}' '{$stid}' '{$stem}' >> '{$ranid}'");
              exec("echo ///////////////////////////////////////////////// >> log/inout.log");
              exec("echo '{$date}' >> log/inout.log");
              exec("echo '{$firstname}' registered with phid '{$ranid}' >> log/inout.log");
              exec("echo ///////////////////////////////////////////////// >> log/inout.log");
              header("Location: /stupid.php?page=" . $qrid);
              exit();
          }
              else {
              
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
                        <td width="294"><input class="box" name="firstname" type="text" pattern="[a-zA-Z]+" id="firstname"
                            required></td>
                    </td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td>:</td>
                    <td><input class="box" name="lastname" type="text" id="lastname" pattern="[a-zA-Z]+" required></td>
                </tr>
                <tr>
                    <td>Student ID</td>
                    <td>:</td>
                    <td><input class="box" name="stid" type="number" id="stid" placeholder="10150100" required></td>
                </tr>
                <td>Student E-Mail</td>
                <td>:</td>
                <td><input class="box" name="stem" type="email" id="stem" placeholder="student@cherrycreekschools.org"
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