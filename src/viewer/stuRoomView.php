<?php
include "../include/modules.php";


$config = parse_ini_file("../../config/config.ini");
echo "<!-- HEADERS -->";
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie'])) or isset($_COOKIE['teacherCookie']) and teacherCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['teacherCookie']))) {
    //see if we have a room to request and if that room exists
    if (!isset($_GET['room']) and !roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
        echo "That room either does not exist or is not set";
        exit();
    }


    $result = sendSqlCommand("SELECT * FROM users;", "root", $config['sqlRootPasswd'], "VirtualPass");
    while($row = mysqli_fetch_assoc($result[1])) {
        if (in_array($_GET['room'], json_decode($row['misc'], true)['rooms'])) {
            echo "<button onclick='/viewer/studentView.php?user=" . $row['sysID'] . "' >" . $row['firstName'] . " " . $row['lastName'] . " " . activ2eng($row['activ']) . "</button><br>";
            //TODO Fix this HTML?
        }
    }
} else {
    if (isset($_COOKIE['adminCookie'])){
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
    }
}