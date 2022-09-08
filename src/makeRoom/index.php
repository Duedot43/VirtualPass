<?php
/** 
 * Home page and navigator
 * 
 * PHP version 8.1
 * 
 * @file     /src/makeRoom/index.php
 * @category Room_Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../include/modules.php";
$config = parse_ini_file("../../config/config.ini");
if (isset($_COOKIE['adminCookie']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie'])) or isset($_COOKIE['teacherCookie']) and teacherCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['teacherCookie']))) {
    if (isset($_POST['rnum'])) {
        $room = installRoom(array("id"=>rand() . rand(), "num"=>htmlspecialchars(preg_replace("/[^0-9.]+/i", "", $_POST['rnum']),  ENT_QUOTES, 'UTF-8')), "root", $config['sqlRootPasswd'], "VirtualPass");
        if ($room[0] == 1) {
            echo "There was an error making the room please try again";
            exit();
        }
        header("Location: /makeRoom/display.php?id=" . $room[2]);
        exit();
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
    <title>Register Room</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/public/style.css"  type="text/css"/>
    <link rel="icon" href="/public/favicon.ico"/>
</head>

<body>
<div class="l-card-container">
    <a>Please input the room number to register.</a>
    <hr/>
    <form method="post">
        <label>
            Room Number:
            <input name="rnum" placeholder="100" type="number" id="rnum" required/>
        </label>
        <!-- Legacy classes are still included, I have no clue if it conflicts -->
        <button type="submit" name="Submit" value="Submit">Register</button>
    </form>
</div>
</body>
</html>