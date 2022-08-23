<?php
include "../include/modules.php";


$config = parse_ini_file("../../config/config.ini");
echo "<!-- HEADERS -->";
//Auth
if (!isset($_COOKIE['adminCookie']) or !adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    header("Location: /admin");
    exit();
}
//View the user info
if (isset($_GET['user'])) {
    if (!userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['user']))) {
        echo "That user does not exist.";
        exit();
    }
    $user = getUserData("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['user']));
    
}
//cycle through all the users and display them
$result = sendSqlCommand("SELECT * FROM users;", "root", $config['sqlRootPasswd'], "VirtualPass");
while($row = mysqli_fetch_assoc($result[1])) {
    echo "<button onclick='/viewer/studentView.php?user=" . $row['sysID'] . "' >" . $row['fisrtName'] . " " . $row['lastName'] . " " . activ2eng($row['activ']) . "</button><br>";
}