<?php

/** 
 * Register room
 * 
 * PHP version 8.1
 * 
 * @file     /src/regRoom.php
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
if (isset($_GET['room']) and roomExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
    header('Location: /?room=' . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
}


// now we make the room
if (isset($_POST['rnum'])) {
    $installRoom = installRoom(array("id"=>preg_replace("/[^0-9.]+/i", "", $_GET['room']), "num"=>preg_replace("/[^0-9.]+/i", "", $_POST['rnum'])), $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
    header("Location: /?room=" . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register Room</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/public/style.css"  type="text/css"/>
    <link rel="icon" href="/public/favicon.ico"/>
</head>

<body>
<div class="l-card-container">
    <a>First time setup. Please input the room number of this QR code to register.</a>
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