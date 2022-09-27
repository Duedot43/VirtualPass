<?php

/** 
 * Manage a teacher
 * 
 * PHP version 8.1
 * 
 * @file     /src/accountTools/teacher/index.php
 * @category Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../../include/modules.php";


$config = parse_ini_file("../../../config/config.ini");
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    // view teacher accounts
    // delete teacher account
    // change uname or password
    // import teacherrs

    // deleting admin
    if (isset($_GET['account']) and teacherCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['account'])) and isset($_GET['action']) and $_GET['action'] == "delete") {
        $teacher = getTeacherByUuid($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['account']));
        $output = sendSqlCommand("DELETE FROM teachers WHERE uname='" . $teacher['uname'] . "';", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
        if ($output[0] == 0) {
            echo "Success! Teacher deleted";
            exit();
        } else {
            // deepcode ignore XSS: BRO STOP IT ITS JUST AN SQL ERROR CODE
            echo "Something went wrong! here is the error " . $output[1];
        }
    }

    //showing actions for an admin
    if (isset($_GET['account']) and teacherCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['account']))) {
        $teacher = getTeacherByUuid($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['account']));
        // deepcode ignore XSS: Is not relevent 
        echo "<button onclick=\"AJAXGet('/accountTools/teacher/?account=" . $teacher['uuid'] . "&action=delete', 'mainEmbed')\" >Delete account</button><br>";
        // deepcode ignore XSS: Is not relevent thats from valid data in the database
        //echo "<button onclick=\"location='/accountTools/admin/?account=" . $admin['uuid'] . "&action=changePasswd'\" >Change password</button><br>";
        exit();
    }

    // showing all the admins
    $result = sendSqlCommand("SELECT * FROM teachers;", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
    echo "<button onclick=\"AJAXGet('/accountTools/teacher/import.php', 'mainEmbed')\" >Import teachers</button><br>";
    while ($row = mysqli_fetch_assoc($result[1])) {
        echo "<button onclick=\"AJAXGet('/accountTools/teacher/?account=" . $row['uuid'] . "', 'mainEmbed')\" >" . $row['uname'] . "</button><br>";
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