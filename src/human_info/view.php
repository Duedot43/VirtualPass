<?php
include "../usr_pre_fls/checks.php";
check_string($_GET['user'], "INCORRECT PHID COOKIE REQUEST");
if (!file_exists("../registered_phid/" . $_GET['user'])){
    echo "THAT USER DOES NOT EXIST!";
    exit();
}
$user_arr = json_decode(file_get_contents("../registered_phid/" . $_COOKIE['phid']), true);
echo '<link href="/style.css" rel="stylesheet" type="text/css" />';
unset($user_arr['activity']['cnum']);
if (isset($_GET['date'])){
    $user_arr = json_decode(file_get_contents("../registered_phid/" . $_COOKIE['phid']), true);
    if (!isset($user_arr['activity'][$_GET['date']])){
        echo "THAT USER DATE DOES NOT EXIST";
        exit();
    }
    unset($user_arr['activity'][$_GET['date']]['date']);
    foreach ($user_arr['activity'][$_GET['date']] as $date_arr){
        echo "User USER left room " . file_get_contents("../registerd_qrids/" . $date_arr['room']) . " at TIME and arrived at TIME2 they were gone for MINUTES and " . $date_arr['timeDep'] - $date_arr['timeArv'] . " Seconds.";

    }
}


foreach ($user_arr['activity'] as $activ){
    print_r($activ['date']);
    echo "<button class='reg' onclick='location=\"/human_info/view.php?user=" . $_GET['user'] . "&date=" . $activ['date'] . "\"' >" . $activ['date'] . "</button><br>";
}
?>