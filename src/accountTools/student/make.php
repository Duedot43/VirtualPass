<?php

/** 
 * Arrive a student
 * 
 * PHP version 8.1
 * 
 * @file     /src/accountTools/student/arrive.php
 * @category Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../../include/modules.php";


$config = parse_ini_file("../../../config/config.ini");
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <title>Make a student</title>
    <meta name="color-scheme" content="dark light">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>';
//Auth
if (!isset($_COOKIE['adminCookie']) or !adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    header("Location: /admin");
    exit();
}
if (isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST['stid']) and isset($_POST['stem']) and isset($_COOKIE['adminCookie']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    //sanatize the user
    $userInfo = sanatizeUser(array($_POST['firstname'], $_POST['lastname'], $_POST['stid'], $_POST['stem']));
    $userInfo[3] = $_POST['stem'];

    //install the user to the system
    $userInstall = installUser($userInfo, $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
    if ($userInstall[0] == 1) {
        echo "Something has gone wrong making the user!";
        exit();
    } else {
        echo "User installed succesfully";
        exit();
    }
}
?>

<body>
    <div class="l-card-container">

        <a>Enter user info </a>
        <hr />

        <form method="post">
            <label>
                First Name:
                <input type="text" pattern="[a-zA-Z]+" name="firstname" id="firstname" required />
                Last Name:
                <input type="text" name="lastname" id="lastname" required />
                Student ID:
                <input type="number" name="stid" id="stid" required />
                Student Email:
                <input type="email" name="stem" id="stem" required>
            </label>
            <button type="submit" name="Submit" value="Submit"> Login </button>

        </form>
    </div>

</body>

</html>