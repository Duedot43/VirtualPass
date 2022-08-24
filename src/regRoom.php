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
if (isset($_GET['room']) and roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
    header('Location: /?room=' . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
}


// now we make the room
if (isset($_POST['rnum'])) {
    $installRoom = installRoom(array("id"=>preg_replace("/[^0-9.]+/i", "", $_GET['room']), "num"=>preg_replace("/[^0-9.]+/i", "", $_POST['rnum'])), "root", $config['sqlRootPasswd'], "VirtualPass");
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
    <link rel="stylesheet" href="/src/public/style.css"  type="text/css"/>
</head>

<body>
    <div class="l-card-container">
        <a>First time setup. Please input the room number of this QR code to register.</a>
        <form method="post">
            <label>
                Room Number:
                <input class="box" name="rnum" autocomplete="off" type="number" id="rnum" required/>
            </label>
<!-- Legacy classes are still included, I have no clue if it conflicts -->
            <button class="reg" type="button" name="Submit" value="Submit"> <button> 
        </form>
    </div>
</body>
</html>