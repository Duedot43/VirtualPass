<?php
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
            exec("rm registered_phid/" . $user . $user);
            exec("echo '{$firstname}' '{$lastname}' '{$stid}' '{$stem}' >> registered_phid/" . $user . $user);
            echo ('<link href="style.css" rel="stylesheet" type="text/css" />Done!');


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