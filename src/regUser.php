<?php

/** 
 * Register room
 * 
 * PHP version 8.1
 * 
 * @file     /src/regUser.php
 * @category Register
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "include/modules.php";
$domain = getDomain();
if (!isset($_GET['room'])) {
    header('Location: /');
    exit();
}
$config = parse_ini_file("../config/config.ini");
if (isset($_COOKIE['id']) and userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']))) {
    header('Location: /?room=' . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
} else {
    setcookie("id", "", time() - 31557600, "/", $domain, true, true);
}



if (isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST['stid']) and isset($_POST['stem']) and sanatizeUser(array("", "", "", $_POST['stem']))[3] and roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
    //sanatize the user
    $userInfo = sanatizeUser(array($_POST['firstname'], $_POST['lastname'], $_POST['stid'], $_POST['stem']));
    $userInfo[3] = $_POST['stem'];

    //install the user to the system
    $userInstall = installUser($userInfo, "root", $config['sqlRootPasswd'], "VirtualPass");
    setcookie("id", $userInstall[2], time() + 31557600, "/", $domain, true, true);
    //Send them back to depart
    header("Location: /doActiv.php?room=" . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
}
?>

<head>
    <link href="/public/style.css" rel="stylesheet" type="text/css" />
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
                    <td width="294"><input class="box" autocomplete="off" value='
                        <?php if (isset($_POST['firstname'])) {
                            echo htmlspecialchars($_POST['firstname'],  ENT_QUOTES, 'UTF-8');
                        }
                        ?>' name="firstname" type="text" pattern="[a-zA-Z]+" id="firstname" required></td>
        </td>
</tr>
<tr>
    <td>Last Name</td>
    <td>:</td>
    <td><input class="box" name="lastname" autocomplete="off" value='
                    <?php if (isset($_POST['lastname'])) {
                        echo htmlspecialchars($_POST['lastname'],  ENT_QUOTES, 'UTF-8');
                    }
                    ?>' type="text" id="lastname" pattern="[a-zA-Z]+" required></td>
</tr>
<tr>
    <td>Student ID</td>
    <td>:</td>
    <td><input class="box" name="stid" autocomplete="off" value='
                    <?php if (isset($_POST['stid'])) {
                        echo htmlspecialchars($_POST['stid'],  ENT_QUOTES, 'UTF-8');
                    }
                    ?>' type="number" id="stid" placeholder="10150100" required></td>
</tr>
<td>Student E-Mail</td>
<td>:</td>
<td><input class="box" name="stem" autocomplete="off" value='
                <?php if (isset($_POST['stem'])) {
                    echo htmlspecialchars($_POST['stid'],  ENT_QUOTES, 'UTF-8');
                }
                ?>' type="email" id="stem" placeholder="student@cherrycreekschools.org" required></td>
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

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Room</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./public/style.css" type="text/css" />
</head>

<body>
    <div>
        <form>
            <label>
                First Name:
                <input />
                Last Name:
                <input />
                Student ID:
                <input />
                Student Email:
                <input>
            </label>
        </form>
    </div>

</body>

</html>