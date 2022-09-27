<?php

/** 
 * See what students are in a specific room
 * 
 * PHP version 8.1
 * 
 * @file     /src/viewer/stuRoomView.php
 * @category Display
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../include/modules.php";


$config = parse_ini_file("../../config/config.ini");
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie'])) or isset($_COOKIE['teacherCookie']) and teacherCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['teacherCookie']))) {
    //see if we have a room to request and if that room exists
    if (!isset($_GET['room']) or !roomExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
        echo "That room either does not exist or is not set";
        exit();
    }

    if (isset($_COOKIE['adminCookie'])) {
        echo "<button onclick=\"AJAXGet('/accountTools/rooms/?room=" . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8') . "', 'mainEmbed')\" >Manage this room</button>";
    }
    $result = sendSqlCommand("SELECT * FROM users;", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
    $departedIds = array();
    $departedTimes = array();
    $date = date("d") . "." . date("m") . "." . date("y");
    while ($row = mysqli_fetch_assoc($result[1])) {
        $misc = json_decode($row['misc'], true);
        if (in_array($_GET['room'], $misc['rooms'])) {
            if ((int) $row['activ'] === 0) {
                $departedIds[] = $row['sysID'];
                $departedTimes[] = array($misc['activity'][$date][$misc['cnum'][0]]['timeDep'], $row['depTime']);
            }
            $border = (int) $row['activ'] === 0 ? 'style="border:orange; border-width:5px; border-style:solid;"' : 'style="border:green; border-width:5px; border-style:solid;"';
            echo "<button id='" . $row['sysID'] . "' onclick=\"AJAXGet('/viewer/studentView.php?user=" . $row['sysID'] . "', 'mainEmbed')\" " . $border . " >" . $row['firstName'] . " " . $row['lastName'] . " " . activ2eng($row['activ']) . "</button><br>";
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
<script>
    let departedIds = <?php echo phpArr2str($departedIds); ?>;
    let departedTimes = <?php echo phpArr2str($departedTimes); ?>;

    function timer(elementId, userArr) {
        var ogInner = document.getElementById(elementId).innerHTML;
        setInterval(function() {
            timeUsed = new Date().getTime() - (userArr[0] * 1000);
            if (timeUsed > userArr[1] * 1000) {
                document.getElementById(elementId).style.border = "red 5px solid";
            }
            document.getElementById(elementId).innerHTML = ogInner + " " + Math.floor(timeUsed / 1000 / 60) + "m " + Math.floor(timeUsed / 1000 % 60) + "s";
        }, 1000);
    }

    for (let i = 0; i < departedIds.length; i++) {
        timer(departedIds[i], departedTimes[i]);
    }
</script>