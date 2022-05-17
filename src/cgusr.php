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
  function check_phid($pid){
    if (is_numeric($pid)){
    }
    else{
      echo("Invalid phid cookie!");
      
      exit();
    }
  }
  //nooooo this code is not stolen fron StackOverflow no never!
if(isset($_GET['user'])) {
    if(isset($_POST['firstname'])) {
      if(isset($_POST['lastname'])) {
        if(isset($_POST['stid'])) {
          if(isset($_POST['stem'])) {
            $user = $_GET['user'];
            $firstname=$_POST['firstname'];
            $lastname=$_POST['lastname'];
            $stid=$_POST['stid'];
            $stem=$_POST['stem'];
            check_phid($user);
            config_set("registered_phid/" . $user, "usr_info", "first_name", $firstname);
            config_set("registered_phid/" . $user, "usr_info", "last_name", $lastname);
            config_set("registered_phid/" . $user, "usr_info", "student_id", $stid);
            config_set("registered_phid/" . $user, "usr_info", "student_email", $stem);
            echo ('<link href="style.css" rel="stylesheet" type="text/css" />Done!');
            exit();


          }
        }
    }
}
}
?>
<title>Change your user</title>
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
                    <td colspan="3"><strong>Re-register! We do not collect data.
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