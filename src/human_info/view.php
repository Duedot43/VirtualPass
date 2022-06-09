<?php
include "../usr_pre_fls/checks.php";
check_string($_GET['user'], "INCORRECT PHID COOKIE REQUEST");
if (!file_exists("../registered_phid/" . $_GET['user'])){
    echo "THAT USER DOES NOT EXIST!";
    exit();
}
echo '<link href="/style.css" rel="stylesheet" type="text/css" />';
if (isset($_GET['date'])){
    $user_arr = json_decode(file_get_contents("../registered_phid/" . $_COOKIE['phid']), true);
    if (!isset($user_arr['activity'][$_GET['date']])){
        echo "THAT USER DATE DOES NOT EXIST";
        exit();
    }
    unset($user_arr['activity'][$_GET['date']]['date']);
    foreach ($user_arr['activity'][$_GET['date']] as $date_arr){
        echo "User " . $user_arr['fname'] . " " . $user_arr['lname'] . " left room " . file_get_contents("../registerd_qrids/" . $date_arr['room']) . " at " . date("H:i:s", $date_arr['timeDep']) . " and arrived at " . date("H:i:s", $date_arr['timeArv']) . " they were gone for " . ($date_arr['timeArv'] - $date_arr['timeDep'])/60 . " minutes and " . $date_arr['timeArv'] - $date_arr['timeDep'] . " Seconds.<br><br>";

    }
    exit();
}
$user_arr = json_decode(file_get_contents("../registered_phid/" . $_COOKIE['phid']), true);
unset($user_arr['activity']['cnum']);

foreach ($user_arr['activity'] as $activ){
    echo "<button class='reg' onclick='location=\"/human_info/view.php?user=" . $_GET['user'] . "&date=" . $activ['date'] . "\"' >" . $activ['date'] . "</button><br>";
}
?>