<?php

/** 
 * Student manager
 * 
 * PHP version 8.1
 * 
 * @file     /src/student/index.php
 * @category RManager
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */

require "../include/modules.php";
$config = parse_ini_file("../../config/config.ini");

if (!isset($_COOKIE['id']) or !userExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']))) {
    header("Location: /student/login.php");
    exit();
} else {
    $user = getUserData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']));
    $apiKey = getApiKeyByUser($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']))[1];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Your info</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>

<body>
    <div class="l-card-container">


        <label>
            First Name:
            <!-- deepcode ignore XSS: ITS AN SQL DB SHUSH -->
            <text><?php echo $user['firstName'];?></text><br>
            Last Name:
            <!-- deepcode ignore XSS: ITS AN SQL DB SHUSH -->
            <text><?php echo $user['lastName'];?></text><br>
            Student ID:
            <!-- deepcode ignore XSS: ITS AN SQL DB SHUSH -->
            <text><?php echo $user['ID'];?></text><br>
            Student Email:
            <!-- deepcode ignore XSS: ITS AN SQL DB SHUSH -->
            <text><?php echo $user['email'];?></text><br>
            API key:
            <!-- deepcode ignore XSS: ITS AN SQL DB SHUSH -->
            <text><?php echo $apiKey;?></text><br>
        </label>

    </div>

</body>

</html>