<?php

/** 
 * Search rooms for teacer
 * 
 * PHP version 8.1
 * 
 * @file     /src/teacher/search.php
 * @category Display
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */

require "../include/modules.php";
$config = parse_ini_file("../../config/config.ini");


if (!isset($_COOKIE['teacherCookie']) or !teacherCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['teacherCookie']))) {
    header("Location: /teacher");
    exit();
}
if (isset($_POST['rnum'])) {
    $result = sendSqlCommand("SELECT * FROM rooms;", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
    while ($row = mysqli_fetch_assoc($result[1])) {
        if ($row['num'] == $_POST['rnum']) {
            header("Location: /viewer/stuRoomView.php?room=" . $row['ID']);
            // TODO FIX ALL THE POST REQUESTS
            exit();
        }
    }
    echo "That room does not exist!";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Search For Room</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>

<body>
    <div class="l-card-container">
        <a>What is your room number?</a>
        <hr />
        <label>
            Room Number:
            <input name="rnum" placeholder="100" type="number" id="rnum" required />
        </label>
        <!-- Legacy classes are still included, I have no clue if it conflicts -->
        <button name="Submit" value="Submit" onclick='AJAXPost("/teacher/search.php", "mainEmbed", encodeData(["rnum"]))'>Search</button>
    </div>
</body>

</html>