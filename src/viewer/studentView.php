<?php

/** 
 * Student Viewer
 * 
 * PHP version 8.1
 * 
 * @file     /src/viewer/studentView.php
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
    if (isset($_GET['user']) and isset($_GET['date']) and isset($_GET['room'])) {
        if (!userExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['user']))) {
            echo "That user does not exist.";
            exit();
        }
        $user = getUserData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['user']));
        $miscData = json_decode($user['misc'], true);
        if (!isset($miscData['activity'][$_GET['date']])) {
            echo "That date does not exist";
            exit();
        }
        if (!in_array($_GET['room'], $miscData['rooms'])) {
            echo "That room does not exist";
            exit();
        }
        $dateArr = $miscData['activity'][$_GET['date']];
        foreach ($dateArr as $occorance) {
            echo htmlspecialchars($user['firstName'],  ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($user['lastName'],  ENT_QUOTES, 'UTF-8') . " departed from room " . htmlspecialchars(getRoomData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $occorance['room'])[1],  ENT_QUOTES, 'UTF-8') . " they were gone for " . gmdate("H:i:s", $occorance['timeArv'] - $occorance['timeDep']) . "<br>";
        }
        exit();
    }
    if (isset($_GET['user']) and isset($_GET['date'])) {
        if (!userExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['user']))) {
            echo "That user does not exist.";
            exit();
        }
        $user = getUserData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['user']));
        $miscData = json_decode($user['misc'], true);
        if (!isset($miscData['activity'][$_GET['date']])) {
            echo "That date does not exist";
            exit();
        }
        $dateArr = $miscData['activity'][$_GET['date']];
        $rooms = array();
        foreach ($dateArr as $occorance) {
            echo "<button onclick=\"AJAX('/viewer/studentView.php?user=" . htmlspecialchars($_GET['user'],  ENT_QUOTES, 'UTF-8') . "&date=" . htmlspecialchars($_GET['date'],  ENT_QUOTES, 'UTF-8') . "&room=" . htmlspecialchars($occorance['room'],  ENT_QUOTES, 'UTF-8') . "', 'mainEmbed')\" >" . htmlspecialchars($occorance['room'],  ENT_QUOTES, 'UTF-8') . "</button><br/>";
        }
        exit();
    }
    if (isset($_GET['user'])) {
        if (!userExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['user']))) {
            echo "That user does not exist.";
            exit();
        }
        $user = getUserData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", htmlspecialchars($_GET['user'],  ENT_QUOTES, 'UTF-8')));
        if (isset($_COOKIE['adminCookie'])) {
            echo "<button onclick=\"AJAX('/accountTools/student/?user=" . htmlspecialchars($_GET['user'],  ENT_QUOTES, 'UTF-8') . "', 'mainEmbed')\" >Manage this user</button>";
        }
        $miscData = json_decode($user['misc'], true);
        $array_keys = array_keys($miscData['activity']);
        foreach ($array_keys as $array_key) {
            echo "<button onclick=\"AJAX('/viewer/studentView.php?user=" . htmlspecialchars($_GET['user'],  ENT_QUOTES, 'UTF-8') . "&date=" . $array_key . "', 'mainEmbed')\" >" . $array_key . "</button>";
        }
        exit();
    }


    //cycle through all the users and display them
    $result = sendSqlCommand("SELECT * FROM users;", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
    $departedIds = array();
    $departedTimes = array();
    $students = array();
    $date = date("d") . "." . date("m") . "." . date("y");
    while ($row = mysqli_fetch_assoc($result[1])) {
        $misc = json_decode($row['misc'], true);
        if ((int) $row['activ'] === 0) {
            $departedIds[] = $row['sysID'];
            $departedTimes[] = array($misc['activity'][$date][$misc['cnum'][0]]['timeDep'], $row['depTime']);
        }
        $border = (int) $row['activ'] === 0 ? 'style="border:orange; border-width:5px; border-style:solid;"' : 'style="border:green; border-width:5px; border-style:solid;"';
        $students[] = "<tr onclick=\"AJAX('/viewer/studentView.php?user=" . $row['sysID'] . "', 'mainEmbed')\" ><td>" . $row['firstName'] . " </td><td>" . $row['lastName'] . "</td><td> " . $row['ID'] . "</td><td>" . activ2eng($row['activ']) . "</td><td " . $border . " id='" . $row['sysID'] . "'></td></tr><br>";
    }
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
    } else {
        header("Location: /teacher/");
    }
    exit();
}
?>

<body>
    <div class="list-nav">
        <label for="search-by">Search By:
            <br />
            <select id="search-by">
                <option value="name"> First Name </option>
                <option value="id"> ID </option>
                <option value="status"> Status </option>

                <input style="border-radius: 0 5px 5px 0; width: 170px; padding-left: 5px;" type="text" id="search-list" onkeyup="searchIndex()" placeholder="Search for names..">
            </select>
        </label>

        <button onclick="sortTable()">Sort names</button>
    </div>

    <table id="index" class="student-list">
        <tr class="header">
            <th>First Name</th>
            <th>Last Name</th>
            <th>Student ID</th>
            <th>Status</th>
            <th style="max-width: 25px;">Time Out</th>
        </tr>
        <?php
        foreach ($students as $student) {
            echo $student;
        }
        ?>

    </table>
    <script>
        if (typeof departedIds === 'undefined') {
            let departedIds = [];
            let departedTimes = [];
        }
        departedIds = <?php echo phpArr2str($departedIds); ?>;
        departedTimes = <?php echo phpArr2str($departedTimes); ?>;


        function timer(ellimentId, userArr) {
            setInterval(function() {

                let timeUsed = Date.now() - (userArr[0] * 1000);
                if (timeUsed > userArr[1] * 1000) {
                    document.getElementById(ellimentId).style.border = "red 5px solid";
                }
                document.getElementById(ellimentId).innerHTML = " " + Math.floor(timeUsed / 1000 / 60) + "m " + Math.floor(timeUsed / 1000 % 60) + "s";
            }, 1000);
        }
        for (i = 0; i < departedIds.length; i++) {
            timer(departedIds[i], departedTimes[i]);
        }
    </script>
</body>

</html>