<?php
$ini = parse_ini_file('../config/config.ini');
if ($ini['override_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['override_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
if (isset($_POST['uname']) and isset($_POST['passwd'])){
    if (file_exists("../mass.json")){
        //do login
        foreach (json_decode(file_get_contents("../mass.json"), true)['user'] as $user_id){
            $user = json_decode(file_get_contents("registered_phid/" . $user_id), true);
            if (strtolower($user['fname']) == strtolower($_POST['uname']) and (int) $user['id'] == (int) $_POST['passwd']){
                setcookie("phid", $user_id, time() + (86400 * 360), "/", $domain, TRUE, TRUE);
                echo "You have been logged in! <input type='button' value='home' onclick='location=\"/\"' >";
                exit();
            }
            echo "Invalid login info!";
        }
    } else{
        echo "The user DB is not set up.";
    }
}
?>
<title>Login</title>
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
</head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<tr>
    <form method="post" name="form" action="login.php">
        <td>
            <table width="100%" border="0" cellpadding="3" cellspacing="1">
                <tr>
                    <td colspan="3"><strong>Login
                            <hr />
                        </strong></td>
                </tr>
                <tr>
                    <td class="text" width="78">First name
                        <td width="6">:</td>
                        <td width="294"><input class="box" name="uname" type="text" id="uname" autocomplete="off" required></td>
                    </td>
                </tr>
                <tr>
                    <td>Student ID</td>
                    <td>:</td>
                    <td><input class="box" name="passwd" type="password" id="passwd" autocomplete="off" required></td>
                </tr>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input class="reg" type="submit" name="Submit" value="Login"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>