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
include "usr_pre_fls/mk_mass.php";
include "usr_pre_fls/checks.php";


$ini = parse_ini_file('../config/config.ini');
if ($ini['overide_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['overide_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
ck_page();
if (isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST['stid']) and isset($_POST['stem']) and filter_var($_POST['stem'], FILTER_VALIDATE_EMAIL)){
  $ranid = rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand() . rand();
  check_string($_GET['room']);
  $user_arr = array(
    "fname"=>strtolower($_POST['firstname']),
    "lname"=>strtolower($_POST['lastname']),
    "email"=>$_POST['stem'],
    "id"=>$_POST['stid'],
    "student_activ"=>0, //0 for departed 1 for arrived just to make it easer on me
    "rooms"=>array(
      $_GET['room']
    ),
    "activity"=>array()
  );
  setcookie("phid", $ranid, time() + (86400 * 360), "/", $domain, TRUE, TRUE);
}
?>

<title>Register Your User</title>
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
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