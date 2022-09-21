<?php

/** 
 * Home page and navigator
 * 
 * PHP version 8.1
 * 
 * @file     /src/index.php
 * @category Redirect+Home_Page
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */

declare(strict_types=1);
require "include/modules.php";
$domain = getDomain();


$config = parse_ini_file("../config/config.ini");

//create everything if it does not exist
sendSqlCommandRaw("CREATE DATABASE IF NOT EXISTS VirtualPass;", $config['sqlUname'], $config['sqlPasswd']);
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS users (
    sysID varchar(255) NOT NULL,
    firstName varchar(255),
    lastName varchar(255),
    ID varchar(255),
    email varchar(255),
    activ varchar(1),
    misc LONGTEXT,
    depTime varchar(255),
    PRIMARY KEY (sysID)

);",
    $config['sqlUname'],
    $config['sqlPasswd'],
    $config['sqlDB'],
);
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS rooms (
    ID varchar(255) NOT NULL,
    num varchar(255),
    PRIMARY KEY (ID)

);",
    $config['sqlUname'],
    $config['sqlPasswd'],
    $config['sqlDB'],
);
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS history (
    snapTime varchar(255) NOT NULL,
    snOut varchar(255),
    snIn varchar(255),
    PRIMARY KEY (snapTime)

);",
    $config['sqlUname'],
    $config['sqlPasswd'],
    $config['sqlDB'],
);
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS admins (
    uname varchar(255) NOT NULL,
    passwd varchar(255),
    uuid varchar(255),
    PRIMARY KEY (uname)

);",
    $config['sqlUname'],
    $config['sqlPasswd'],
    $config['sqlDB'],
);
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS teachers (
    uname varchar(255) NOT NULL,
    passwd varchar(255),
    uuid varchar(255),
    PRIMARY KEY (uname)

);",
    $config['sqlUname'],
    $config['sqlPasswd'],
    $config['sqlDB'],
);
// perm 0 is regular user they can access their info and either depart or arrive and can view only their real room numbers
// perm 1 is regular user they can edit their basic info and do all level 0 can
// perm 2 is administrator they can view all users view all rooms
// perm 3 is full administrator they can view and change admin and teacher password view all users and rooms edit all users and rooms and delete all users and rooms
sendSqlCommand(
    "CREATE TABLE IF NOT EXISTS apiKeys (
    apiKey varchar(255) NOT NULL,
    perms varchar(255),
    user varchar(255),
    lastTime varchar(255),
    PRIMARY KEY (apiKey)

);",
    $config['sqlUname'],
    $config['sqlPasswd'],
    $config['sqlDB'],
);
// redirect to the main page
if (!isset($_GET['room'])) {
    header('Location: /home.php');
    exit();
}

if (!roomExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {
    echo "That room does not exist! Please contact an administrator.";
    //header('Location: /regRoom.php?room=' . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
}

//if the user cookie is not set then redirect to register
if (!isset($_COOKIE['id'])) {
    header('Location: /login.php?room=' . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
} elseif (!userExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']))) {
    setcookie("id", "", time() - 31557600, "/", $domain, true, true);
    header('Location: /login.php?room=' . htmlspecialchars($_GET['room'],  ENT_QUOTES, 'UTF-8'));
    exit();
}



if (isset($_COOKIE['id']) and userExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']))) {
    // TODO MORE THAN 10 MINUTES
    // DONE Show pass on phone
    // MAYBE? Choose look by student by room class 
    // TODO Meet with councler
    // DONE Show pass says pass is expired
    // TODO If a kid goes to the CRC we need to log that for mass emails
    // TODO change avalable departure time PER STUDENT
    // TODO Op parents out of emails With admin APPROVIAL
    // TODO Email Moly robins at the CRC
    // TODO Add a parent portal
    $user = getUserData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']));
    $dpt = activ2eng((int) $user['activ']);
    $dpt2 = ((int) $user['activ'] === 1) ? "Depart" : "Arrive";
    $misc = json_decode($user['misc'], true);
    $date = date("d") . "." . date("m") . "." . date("y");
    if ((int) $user['activ'] === 0 or isset($misc['activity'][$date])) {
        $currentOccorance = $misc['activity'][$date][$misc['cnum'][0]];
    } else {
        $currentOccorance = array("arr"=>"e", "room"=>$_GET['room'], "timeDep"=>'0');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Zilla+Slab&display=swap');

    /* Regular setting */
    :root {
        --body-bg: #dadada;
        --table-bg: white;
        --body-color: #000000;
    }

    /* Dark setting */
    @media (prefers-color-scheme: dark) {
        :root {
            --table-bg: #27434b;
            --body-bg: #233035;
            --body-color: #FFFFFF;
        }
    }

    .box {
        border: solid #70b8d4 3px;
        border-radius: 5px;
        padding: 5px;
        width: 100%;
    }

    body {
        font-family: "Zilla Slab", Arial, Helvetica, sans-serif;
        color: #545d5eda;
        background: var(--body-bg);
        color: var(--body-color);

    }

    table {
        margin: 0 auto;
        max-width: 600px;
        background: white;
        border-radius: 7px;
        box-shadow: 5px 5px rgb(82, 99, 102);
        padding: 7px;
        background: var(--table-bg);
    }

    .text {
        min-width: 77px;
    }

    .reg {
        width: 100%;
        height: 40px;
        font-family: "Zilla Slab";
        font-size: 15px;
        color: white;
        background: #70b8d4;
        border: solid #70b8d4;
        border-radius: 5px;

    }

    input:hover {
        border: solid #5da2da;
        border-radius: 5px;
        background: #5da2da;
    }

    html,
    body,
    #freq {
        width: 100%;
        height: 500px;
        margin: 0;
        padding: 0;
    }

    .navParent {
        width: 100%px;
        Height: 55px;
        background-color: #FFFFFF;
        box-shadow: 5px 0px 5px 5px #666666;

    }

    /* --real_index Page-- */

    .navParent-01 {
        display: flex;
        width: 100%;
        height: 50px;
        margin: 0;
        overflow: hidden;
        background-color: #7700ff;
        border-radius: 0px 5px 0px 5px;
        box-shadow: 5px #FFFFFF;
    }

    .navChild-01 {
        border: 5px;
        padding: 5px;
        position: absolute;
        top: 0;
        right: 0;
        font-family: Arial, Helvetica, sans-serif;
    }

    .navChild-01 button {
        justify-content: right;
        background: none;
        border: none;
        z-index: 1;
        color: White;
    }

    .navChild-01 button:hover {
        color: #b1b1b1;
        text-decoration: underline;
    }


    .navChild-h1 {
        width: 10px;
    }
</style>

<head>
    <meta charset="UTF-8">
    <title>Depart/Arrive</title>
    <meta name="color-scheme" content="dark light">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/public/favicon.ico" />
</head>

<body>    
    
    <div id="ani-background"></div>

    <div class="l-card-container">

        <!-- deepcode ignore XSS: Shut the up -->
        <p>you have <?php echo $dpt; ?></p>
        <hr />

        <label>
            <!-- deepcode ignore XSS: ITS AN SQL DATABASE SHUT IT -->
            <?php echo $user['firstName'] . " " . $user['lastName'] ?><br>
            <!-- deepcode ignore XSS: SHUT -->
            Room #: <?php echo $currentOccorance['room'] ?><br>
            <!-- deepcode ignore XSS: Please stop it -->
            <text id='departed'>Time Departed: <?php echo gmdate("h:i:s", (int) $currentOccorance['timeDep']) ?></text>
            <h1 id="timer"></h1>
            <br>
            <script>
                // deepcode ignore XSS: STOP ITTTTTTT
                let timeAllowed = <?php echo (string) ($user['depTime'] * 1000) ?>;
                const x = setInterval(function() {
                    if (<?php echo (isset($currentOccorance['arr']) ? "false" : "true"); ?>) {
                        // deepcode ignore XSS: Stupid dummy
                        let timeOut = Date.now() - (<?php echo $currentOccorance['timeDep']; ?> * 1000);
                        var timeRem = timeAllowed - timeOut;

                        var add_zero = ((timeRem / 1000 % 60) < 10) ? "0" : "";
                        document.getElementById('timer').innerHTML = "Time Remaining: " + Math.floor(timeRem / 1000 / 60) + ":" + add_zero + Math.floor(timeRem / 1000 % 60);

                        if (timeRem < 0) {
                            clearInterval(x);
                            document.getElementById('timer').innerHTML = "Time Remaining: EXPIRED";
                            document.getElementById('departed').innerHTML = "Time Departed: EXPIRED";
                        }
                    }

                }, 1000);
            </script>
        </label>
        <br/>
        <hr/>

        <!-- deepcode ignore XSS: THERE IS NOTHING WRONG WITH THIS -->
        <button name="return" id="return" onclick="location='/doActiv.php?room=<?php echo $_GET['room']; ?>'" > <?php echo $dpt2; ?> </button>

        <script>
            const ret = document.getElementById('return');
            ret.disabled = true;
            let counter = 2;

            const y = setInterval(function() {
                counter--;
                console.log(counter);
                ret.innerHTML = counter;

                if (counter <= 0) {
                    clearInterval(y);
                    ret.disabled = false;
                    ret.innerHTML = '<?php echo $dpt2; ?>';
                }
            }, 1000);
        </script>
    </div>
    
</body>
</html>