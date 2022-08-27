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

// and sanatizeUser(array("", "", "", $_POST['stem']))[3] and roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))

if (isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST['stid']) and isset($_POST['stem']) and sanatizeUser(array("", "", "", $_POST['stem']))[3] and roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
    //sanatize the user
    $userInfo = sanatizeUser(array($_POST['firstname'], $_POST['lastname'], $_POST['stid'], $_POST['stem']));
    $userInfo[3] = $_POST['stem'];

    //install the user to the system
    $userInstall = sendSqlCommand("SELECT * FROM users", "root", $config['sqlRootPasswd'], "VirtualPass");
    while ($row = mysqli_fetch_array($userInstall[1])) {
        if (strToLower($row['firstName']) == strtolower($_POST['firstname']) and strToLower($row['lastName']) == strtolower($_POST['lastname']) and strToLower($row['ID']) == strtolower($_POST['stid']) and strToLower($row['email']) == strtolower($_POST['stem'])) {
            setcookie("id", $row["sysID"], time() + 31557600, "/", $domain, true, true);
            //Send them back to depart
            header("Location: /doActiv.php?room=" . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
            exit();
        }
    }
    echo "Your user info is invalid or your user does not exist please contact an administrator if this continues";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>

<body>
    <div class="l-card-container">

        <a>Please Login </a>
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
            <button type="submit" name="Submit" value="Submit"> Submit </button>

        </form>
    </div>

</body>

</html>