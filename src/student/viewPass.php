<?php

/** 
 * View Student Pass
 * 
 * PHP version 8.1
 * 
 * @file     /src/student/viewPass.php
 * @category Viewer
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../include/modules.php";


$config = parse_ini_file("../../config/config.ini");
if (isset($_COOKIE['id']) and userExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^a-zA-Z0-9]/", "", $_COOKIE['id']))) {
    $user = getUserData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^a-zA-Z0-9]/", "", $_COOKIE['id']));
    $misc = json_decode($user['misc'], true);
    $date = date("d") . "." . date("m") . "." . date("y");
    $currentOccorance = $misc['activity'][$date][$misc['cnum'][0]];
} else {
    header('Location: /student/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Hall Pass</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>

<body>

    <div id="ani-background"></div>

    <div class="l-card-container">


        <label>
            <!-- deepcode ignore XSS: ITS AN SQL DATABASE SHUT IT -->
            <?php echo $user['firstName'] . " " . $user['lastName'] ?><br>
            <!-- deepcode ignore XSS: SHUT -->
            Room #: <?php echo $currentOccorance['room'] ?><br>
            <?php // TODO do timer ?>
            <!-- deepcode ignore XSS: Please stop it -->
            <text id='departed' >Time Departed: <?php echo gmdate("h:i:s", $currentOccorance['timeDep']) ?></text>
            <h1 id="timer"></h1>
            <br>
            <script>

            //Sets timer to 10 minutes
            //TODO integrate PHP timer to JS timer
                const t_time = new Date().getTime()+600000;
                const x = setInterval(function () {
                //Gets epoch time data to subtract from our 10 minutes
                    const c_time = new Date().getTime();
                    let time_span = t_time - c_time;

                    const minutes = Math.floor((time_span % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((time_span % (1000 * 60)) / 1000);

                    //t_time(timer_time) c_time(current_time) Maybe come up with better variable names?
                    console.log(t_time)
                    console.log(c_time)
                    let time_add = seconds < 10 ? "0" : "";

                    document.getElementById('timer').innerHTML = "Time Remaining: " + minutes + ":" + time_add + seconds;

                    if (time_span < 0) {
                        clearInterval(x);
                        document.getElementById('departed').innerHTML = "EXPIRED";
                        document.getElementById('timer').innerHTML = "Time Remaining: EXPIRED";
                    }
                }, 1000);

            </script>
        </label>

    </div>

</body>

</html>