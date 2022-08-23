<?php
include "include/modules.php";
$domain = getDomain();
if (!isset($_GET['room'])) {
    header('Location: /');
    exit();
}
$config = parse_ini_file("../config/config.ini");
if (roomExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_GET['room']))) {

    $userData = getUserData("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']));
    $departureData = json_decode($userData['misc'], true);

    //Depart or arrive the user
    if ($userData['activ'] == 1) {
        $userData['activ'] = 0;
    } else {
        $userData['activ'] = 1;
    }
    //that's simple right?

    //register their room
    if (!in_array($_GET['room'], $departureData['rooms'])) {
        array_push($departureData['rooms'], $_GET['room']);
    }

    $date = date("d") . "." . date("m") . "." . date("y");

    if (!isset($departureData['activity'][$date])) {
        $departureData['activity'][$date] = array();
        $departureData['cnum'] = array(0,0);
    }

    //determin the time
    if ($departureData['cnum'][1] == 0) {
        $timeDep = time();
        $timeArv = "";
        $departureData['cnum'][1] = 1;
    } else{
        $timeDep = $departureData['activity'][$date][$departureData['cnum'][0]]['timeDep'];
        $timeArv = time();
        $departureData['cnum'][1] = 0;
        $set = true;
    }

    //mark down the time that the user does an activity
    $departureData['activity'][$date][$departureData['cnum'][0]] = array(
        "room"=>preg_replace("/[^0-9.]+/i", "", $_GET['room']),
        "timeDep"=>$timeDep,
        "timeArv"=>$timeArv
    );
    if ($set){
        $departureData['cnum'][0] = $departureData['cnum'][0] + 1;
    }
    print_r($departureData);
    sendSqlCommand("UPDATE users 
    SET 
        activ = '" . $userData['activ'] . "'
    WHERE
        sysId=" . preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']) . ";", "root", $config['sqlRootPasswd'], "VirtualPass");


    sendSqlCommand("UPDATE users 
    SET 
        misc = '" . json_encode($departureData) . "'
    WHERE
        sysId=" . preg_replace("/[^0-9.]+/i", "", $_COOKIE['id']) . ";", "root", $config['sqlRootPasswd'], "VirtualPass");
    header("Location: /?room=" . $_GET['room']);
} else{
    header("Location: /?room=" . $_GET['room']);
}
