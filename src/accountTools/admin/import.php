<?php

/** 
 * Import admins
 * 
 * PHP version 8.1
 * 
 * @file     /src/accountTools/admin/import.php
 * @category Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../../include/modules.php";
require "../../include/customModules.php";

$config = parse_ini_file("../../../config/config.ini");
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <title>Import Admins</title>
    <meta name="color-scheme" content="dark light">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>';
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    if (!canImport()) {
        echo "You do not have the tools to import your database";
        exit();
    }
    if (isset($_FILES["cs"])) {
        $file = $_FILES["csv"]["tmp_name"];
        move_uploaded_file($file, "./csv");
        $admins = decompileAdmin(file_get_contents("./csv"));
        if (!$admins[0]) {
            echo "Something has gone wrong with the import of your file please try again";
            exit();
        }
        unlink("./csv");
        foreach ($admins[1] as $adminRecord) {
            $output = sendSqlCommand("INSERT admins VALUES('" . $adminRecord['uname'] . "', '" . $adminRecord['passwd'] . "', '" . $adminRecord['uuid'] . "')", $config['sqlUname'], $config['sqlPasswd'], $config['sqlDB']);
            if ($output[0] != 0) {
                echo "Something has gone wrong importing the database please try again";
                exit();
            }
        }
        echo "Success! Database imported!";
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Import admins</title>
<tr>
    <td>
        <table width="100%" border="0" cellpadding="3" cellspacing="1">
            <div id="main">
                <tr>
                    <td colspan="3"><strong>Upload CSV file
                            <hr />
                        </strong></td>
                </tr>
                <tr>
                    <td><input type="file" name="csv" id="csv">Upload the CSV file</td>
                </tr>
            </div>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><button onclick="readFileAsText()">Upload!</button></td>
</tr>
</table>
</td>
</tr>
</table>
<script>
    function parseCsv(data) {
        let csvData = [];
        let lbreak = data.split("\n");
        lbreak.forEach(res => {
            csvData.push(res.split(","));
        });
        return csvData;
    }
    const readFileAsText = function() {
        const fileToRead = document.getElementById('csv').files[0]
        const fileReader = new FileReader()

        fileReader.addEventListener('load', function(fileLoadedEvent) {
            const content = fileLoadedEvent.target.result
            const csvData = parseCsv(content);
            console.log(csvData);

        })

        fileReader.readAsText(fileToRead, 'UTF-8')
    }
</script>