<?php

/** 
 * Manage a room
 * 
 * PHP version 8.1
 * 
 * @file     /src/accountTools/rooms/index.php
 * @category Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../../include/modules.php";


$config = parse_ini_file("../../../config/config.ini");
echo "<!-- HEADERS -->";
if (!isset($_GET['room'])) {
    echo "Your room is not set";
    exit();
}
if (!roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
    echo "That room does not exist!";
    exit();
}
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    if (isset($_POST['rnum'])) {
        $output = installRoom(array("id" => preg_replace("/[^0-9.]+/i", "", $_GET['room']), "num" => preg_replace("/[^0-9.]+/i", "", $_POST['rnum'])), "root", $config['sqlRootPasswd'], "VirtualPass");
        if ($output[0] == 1) {
            echo "Something has gone wrong please try again.";
            exit();
        } else {
            echo "Success! room number changed!";
            exit();
        }
    }
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Room Number</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/public/style.css"  type="text/css"/>
    <link rel="icon" href="/public/favicon.ico"/>
</head>

<body>
<div class="l-card-container">
    <a>Change the room number</a>
    <hr/>
    <form method="post">
        <label>
            Room Number:
            <input name="rnum" placeholder="100" type="number" id="rnum" required/>
        </label>
        <!-- Legacy classes are still included, I have no clue if it conflicts -->
        <button type="submit" name="Submit" value="Submit">Register</button>
    </form>
</div>
</body>
</html>