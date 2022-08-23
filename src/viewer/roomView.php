<?php
include "../include/modules.php";


$config = parse_ini_file("../../config/config.ini");
echo "<!-- HEADERS -->";
//Auth
if (!isset($_COOKIE['adminCookie']) or !adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    header("Location: /admin");
    exit();
}
//see if we are asking for one room
if (isset($_GET['room'])) {
    if (!roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
        echo "That room does not exist.";
        exit();
    }
    $room = getRoomData("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']));
    
}
//get all the rooms
$result = sendSqlCommand("SELECT * FROM rooms;", "root", $config['sqlRootPasswd'], "VirtualPass");
while($row = mysqli_fetch_assoc($result[1])) {
    echo "<button onclick='/viewer/roomView.php?room=" . $row['ID'] . "' >" . $row['num'] . "</button><br>";
}