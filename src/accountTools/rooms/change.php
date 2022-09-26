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
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <title>Change room info</title>
    <meta name="color-scheme" content="dark light">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>';
if (!isset($_GET['room'])) {
    echo "Your room is not set";
    exit();
}
if (!roomExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
    echo "That room does not exist!";
    exit();
}
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    if (isset($_POST['rnum']) and isset($_GET['room'])) {
        $output = sendSqlCommand("UPDATE rooms SET num=" . preg_replace("/[^0-9.]+/i", "", $_POST['rnum']) . " WHERE ID=" . preg_replace("/[^0-9.]+/i", "", $_GET['room']) . ";", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
        if ($output[0] == 1) {
            echo "Something has gone wrong please try again.";
            exit();
        } else {
            echo "Success! room number changed!";
            exit();
        }
    } elseif (isset($_GET['room'])) {
        $room = getRoomData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['room']));
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>

<body>
    <div class="l-card-container">
        <a>Change the room number</a>
        <hr />
        <label>
            Room Number:
            <!-- deepcode ignore XSS: SQL DB -->
            <input name="rnum" value="<?php echo $room['num']; ?>" type="number" id="rnum" required />
        </label>
        <!-- Legacy classes are still included, I have no clue if it conflicts -->
        <!-- deepcode ignore XSS: Shush -->
        <button name="Submit" value="Submit" onclick='AJAXPOST("/accountTools/rooms/change.php?room=<?php echo $_GET["room"]; ?>", "mainEmbed", encodeData(["rnum"]))'>Register</button>
    </div>
</body>

</html>