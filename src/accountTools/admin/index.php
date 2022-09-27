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
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    // view admin accounts
    // delete admin account
    // change uname or password
    // import admins

    // deleting admin
    if (isset($_GET['account']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['account'])) and isset($_GET['action']) and $_GET['action'] == "delete") {
        $admin = getAdminByUuid($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['account']));
        $output = sendSqlCommand("DELETE FROM admins WHERE uname='" . $admin['uname'] . "';", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
        if ($output[0] == 0) {
            echo "Success! Admin deleted";
            exit();
        } else {
            // deepcode ignore XSS: BRO STOP IT ITS JUST AN SQL ERROR CODE
            echo "Something went wrong! here is the error " . $output[1];
        }
    }

    //showing actions for an admin
    if (isset($_GET['account']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['account']))) {
        $admin = getAdminByUuid($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['account']));
        // deepcode ignore XSS: Is not relevent 
        echo "<button onclick=\"AJAXGet('/accountTools/admin/?account=" . $admin['uuid'] . "&action=delete', 'mainEmbed')\" >Delete account</button><br>";
        // deepcode ignore XSS: Is not relevent thats from valid data in the database
        //echo "<button onclick=\"location='/accountTools/admin/?account=" . $admin['uuid'] . "&action=changePasswd'\" >Change password</button><br>";
        exit();
    }

    // showing all the admins
    $result = sendSqlCommand("SELECT * FROM admins;", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
    $importAdmin = "<button onclick=\"AJAXGet('/accountTools/admin/import.php', 'mainEmbed')\" >Import admins</button><br>";
    while ($row = mysqli_fetch_assoc($result[1])) {
        $admins[] = "<tr onclick=\"AJAXGet('/accountTools/admin/?account=" . $row['uuid'] . "', 'mainEmbed')\" ><td>" . $row['uname'] . "</td><tr>";
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

<div class="list-nav">
    <label for="search-by">Search By:
        <br />
        <select id="search-by" style="margin: 0;">
            <option value="name"> First Name </option>
            <option value="id"> ID </option>

            <input style="border-radius: 0 5px 5px 0; width: 170px; padding-left: 5px; margin: 0;" type="text" id="search-list" onkeyup="searchIndex()" placeholder="Search for names..">
        </select>
    </label>

    <button onclick="sortTable()">Sort names</button>

    <?php echo $importAdmin; ?>
</div>

<table id="index" class="student-list">
    <tr class="header">
        <th>First Name</th>
        <th>Last Name</th>
    </tr>
    <?php
    foreach ($admins as $admin) {
        echo $admin;
    }
    ?>

</table>
