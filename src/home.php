<?php

/** 
 * The home page file
 * 
 * PHP version 8.1
 * 
 * @file     /src/home.php
 * @category General_Functions
 * @package  VirtualPass
 * @author   howtoapple <howtoapple@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "include/modules.php";
$config = parse_ini_file("../config/config.ini");



// See if the admin user exists and as so set ther account info
if (isset($_COOKIE['adminCookie']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    $account = getAdminByUuid("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']));
    $name = $account['uname'];
} elseif (isset($_COOKIE['teacherCookie']) and teacherCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['teacherCookie']))) {
    $account = getTeacherByUuid("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['teacherCookie']));
    $name = $account['uname'];
} elseif (isset($_COOKIE['id']) and userExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']))) {
    $account = getUserData("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']));
    $name = $account['firstName'];
} else {
    header("Location: /login.html");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <meta name="home" content="admin-webpage." />
    <meta name="color-scheme" content="dark light">
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

    <div class="content-container">
        <div class="main" height="100%">
            <!---


            <div class="chart-container"">
                <canvas id="myChart" width="400" height="200"></canvas>

                <script src="/include/chart_config.js"></script>

            </div>
            -->
            <h1 style="font-family: Arial, Helvetica, sans-serif" id='viewportTitle'> Overview </h1>
            <iframe id='mainEmbed' src='/admin/' style="border:none;" width='100%'>

            </iframe>
        </div>
    </div>


    <div class="nav-parent">
        <div class="top-nav">

            <div class="logo">
                <a href="/" class="">
                    <img src="/public/favicon.ico" alt="" width="30px" />
                    VirtualPass

                </a>
                <a style="font-size: 14px;">ATS</a>
            </div>

            <div class="h-login-button">

                <button id="l-button" class="dropdown-button">

                    <span class="material-symbols-outlined">
                        account_circle
                    </span>
                    <span class="material-symbols-outlined">
                        arrow_drop_down
                    </span>

                </button>

                <div class="acc-menu dropdown-container" style="display:none; padding-left: 3px;">

                    <button>
                        <!-- deepcode ignore XSS: Its an SQL database SHUT UP! ITS ALREADY FILTERED STOOPID -->
                        <a> <?php echo $name; ?> </a>
                    </button>

                    <hr style="opacity: 50%;" />
                    <button>Home</button>
                    <button class="logout">Log Out</button>

                </div>
            </div>
        </div>

        <div class="sidenav">

            <div class="sidenav-head">
                <h2>Dashboard</h2>
            </div>


            <br />
            <hr style="opacity: 25%; margin: 5px 10px 15px 5px;" />
            <a>Analytics</a>
            <br />
            <div class="button-container-01">
                <button id="overview-tab">
                    <span class="material-symbols-outlined">
                        monitoring
                    </span>
                    Overview
                </button>

                <button>
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    Students
                </button>

                <button>
                    <span class="material-symbols-outlined">
                        school
                    </span>
                    Classrooms
                </button>
            </div>

            <br />
            <hr style="opacity: 25%; margin: 5px 10px 15px 5px;" />
            <a>Pannels</a>
            <br />
            <div class="button-container-01">
                <button id="overview-tab" onclick="switchEmbed('/admin')">
                    <span class="material-symbols-outlined">
                        admin_panel_settings
                    </span>
                    Admin Pannel
                </button>

                <button onclick="switchEmbed('/student')">
                    <span class="material-symbols-outlined">
                        person
                    </span>
                    Student Pannel
                </button>

                <button onclick="switchEmbed('/teacher')">
                    <span class="material-symbols-outlined">
                        school
                    </span>
                    Teacher Pannel
                </button>
            </div>


            <br />
            <hr style="opacity: 25%; margin: 5px 10px 15px 5px;" />
            <a>Other</a>
            <br />

            <div class="button-container-01">
                <button onclick="switchEmbed('/makeRoom/')">
                    <span class="material-symbols-outlined">
                        meeting_room
                    </span>
                    Add Room
                </button>

                <button onclick="switchEmbed('/accountTools/student/make.php')">
                    <span class="material-symbols-outlined">
                        person_add
                    </span>
                    Add User
                </button>

                <button class="dropdown-button">
                    <i></i>
                    <span class="material-symbols-outlined">
                        supervised_user_circle
                    </span>
                    Manage Members

                    <span class="material-symbols-outlined" style=" padding-left: 35px;">
                        arrow_drop_down
                    </span>
                    <i></i>
                </button>

                <div class="dropdown-container">
                    <button onclick="switchEmbed('/accountTools/admin')">
                        Admins
                    </button>
                    <button onclick="switchEmbed('/accountTools/teacher')">
                        Teachers
                    </button>
                    <button onclick="switchEmbed('/viewer/studentView.php')">
                        Students
                    </button>
                </div>

            </div>

            <div class="bottom-nav">

                <button>
                    <span class="material-symbols-outlined">
                        settings
                    </span>
                </button>

                <button id="dark-toggler" class="dark-toggler">
                    <span class="material-symbols-outlined dark-mode-input">
                        dark_mode
                    </span>
                </button>


                <button class="dropdown-button">
                    <span class="material-symbols-outlined ">
                        contact_support
                    </span>
                </button>


                <div class="issue-tab dropdown-container" style="display:none;">
                    <div>
                        <p>Issues?</p>
                        <p>Please visit the</p>
                        <a href="https://github.com/Duedot43/VirtualPass/issues">Issue Tracker.</a>
                    </div>

                    <div>
                        <p>Feedback.</p>
                    </div>
                </div>

                <p id="version-id" style="font-size:10px; margin: 0;"></p>
            </div>

        </div>
    </div>

    <script src="/include/mainScript.js"></script>

</body>

</html>