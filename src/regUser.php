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

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="src/public/style.css" type="text/css" />
    <link rel="icon" href="src/favicon.ico"/>
</head>

<body>
<div class="l-card-container">

    <a>Register your user. (You'll Only have to do this once.)</a>
    <hr/>

    <form method="post">
        <label>
            First Name:
            <input type="text" pattern="[a-zA-Z]+" required/>
            Last Name:
            <input type="text" required/>
            Student ID:
            <input  type="number" required/>
            Student Email:
            <input type="email" required>
        </label>
        <button type="submit"> Submit </button>

    </form>
</div>

</body>

</html>