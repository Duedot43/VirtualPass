<?php

/** 
 * Manage an admin
 * 
 * PHP version 8.1
 * 
 * @file     /src/accountTools/admin/index.php
 * @category Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../../include/modules.php";


$config = parse_ini_file("../../../config/config.ini");
echo "<!-- HEADERS -->";
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    // view admin accounts
    // delete admin account
    // change uname or password
    // import admins

    // deleting admin
    if (isset($_GET['account']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['account'])) and isset($_GET['action']) and $_GET['action'] == "delete") {
        $admin = getAdminByUuid("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['account']));
        $output = sendSqlCommand("DELETE FROM admins WHERE uname='" . $admin['uname'] . "';", "root", $config['sqlRootPasswd'], "VirtualPass");
        if ($output[0] == 0) {
            echo "Success! User deleted";
            exit();
        } else {
            // deepcode ignore XSS: BRO STOP IT ITS JUST AN SQL ERROR CODE
            echo "Something went wrong! here is the error " . $output[1];
        }
    }
    /*
    // changing admin
    if (isset($_GET['account']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['account'])) and isset($_GET['action']) and $_GET['action'] == "delete") {
        $admin = getAdminByUuid("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['account']));
        $output = sendSqlCommand("DELETE FROM admins WHERE uname=" . $admin['uname'] . ";", "root", $config['sqlRootPasswd'], "VirtualPass");
        if ($output[0] == 0) {
            echo "Success! User deleted";
            exit();
        } else {
            // deepcode ignore XSS: BRO STOP IT ITS JUST AN SQL ERROR CODE
            echo "Something went wrong! here is the error " . $output[1];
        }
    }
    */
    //showing actions for an admin
    if (isset($_GET['account']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['account']))) {
        $admin = getAdminByUuid("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['account']));
        // deepcode ignore XSS: Is not relevent 
        echo "<button onclick='/accountTools/admin/?account=" . $admin['uuid'] . "&action=delete' >Delete account</button><br>";
        // deepcode ignore XSS: Is not relevent thats from valid data in the database
        //echo "<button onclick='/accountTools/admin/?account=" . $admin['uuid'] . "&action=changePasswd' >Change password</button><br>";
        exit();
    }

    // showing all the admins
    $result = sendSqlCommand("SELECT * FROM admins;", "root", $config['sqlRootPasswd'], "VirtualPass");
    echo "<button onclick='/accountTools/admin/import.php' >Import admins</button><br>";
    while ($row = mysqli_fetch_assoc($result[1])) {
        echo "<button onclick='/accountTools/admin/?account=" . $row['uuid'] . "' >" . $row['uname'] . "</button><br>";
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