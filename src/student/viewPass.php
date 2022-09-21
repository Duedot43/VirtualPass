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
            <?php // TODO do timer 
            ?>
            <!-- deepcode ignore XSS: Please stop it -->
            <text id='departed'>Time Departed: <?php echo gmdate("h:i:s", $currentOccorance['timeDep']) ?></text>
            <h1 id="timer"></h1>
            <br>
            <script>
                //Sets timer to 10 minutes
                //TODO integrate PHP timer to JS timer
                //THIS NEEDS TO BE A PHP VALUE (timeOut - (ctime - timeDep)) * 1000
                
                // deepcode ignore XSS: STOP ITTTTTTT
                let timeAllowed = <?php echo $user['depTime'] * 1000?>;
                const x = setInterval(function() {
                   // deepcode ignore XSS: Stupid dummy
                    let timeOut = Date.now() - (<?php echo $currentOccorance['timeDep']; ?> * 1000);
                    var timeRem = timeAllowed - timeOut;

                    var add_zero = ((timeRem / 1000) < 10) ? "0" : "";
                    document.getElementById('timer').innerHTML = "Time Remaining: " + Math.floor(timeRem / 1000 / 60) + ":" + add_zero + Math.floor(timeRem / 1000 % 60);

                    if (timeRem < 0) {
                        clearInterval(x);
                        document.getElementById('timer').innerHTML = "Time Remaining: EXPIRED";
                        document.getElementById('departed').innerHTML = "Time Departed: EXPIRED";
                    }

                }, 1000);
            </script>
        </label>

    </div>

</body>

</html>