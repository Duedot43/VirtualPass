<?php
include "usr_pre_fls/checks.php";


function snapshot(){
    if (file_exists("../mass.json")){
        $mass = array();
        $usersDep = 0;
        $usersArv = 0;
        foreach ($mass['user'] as $user){
            $user_arr = json_decode(file_get_contents("registered_phid/" . $user), true);
            if ($user_arr['student_activ'] == 0){
                $usersDep = $usersDep+1;
            }
        }

        foreach ($mass['user'] as $user){
            $user_arr = json_decode(file_get_contents("registered_phid/" . $user), true);
            if ($user_arr['student_activ'] == 1){
                $usersArv = $usersArv+1;
            }
        }
    }
    $time = time();
    $mass['history'][time()] = array(
        "out"=>$usersDep,
        "in"=>$usersArv
    );
    write_json($mass, "history.json");
}
ck_page();
check_string($_GET['room'], "INVALID ROOM VALUE NOT NUMERIC");
snapshot();
if (!isset($_COOKIE['phid']) or !file_exists("registered_phid/" . $_COOKIE['phid'])){
    echo "YOU CANNOT BE HERE WITHOUT A COOKIE!";
    exit();
}

$user_json = json_decode(file_get_contents("registered_phid/" . $_COOKIE['phid']), true);


if ($user_json['student_activ'] == 0){
    $user_json['student_activ'] = 1;
} else{
    $user_json['student_activ'] = 0;
}


$date = date("d") . "." . date("m") . "." . date("y");
if ($user_json['activity']['cnum'][1] == 1){
    $time1 = time();
    $time2 = "";
    $user_json['activity']['cnum'][1] = $user_json['activity']['cnum'][1] = 2;
} else{
    $time1 = $user_json['activity'][$date][$user_json['activity']['cnum'][0]]['timeDep'];
    $time2 = time();
    $user_json['activity']['cnum'][1] = $user_json['activity']['cnum'][1] = 1;
}
if (!isset($user_json['activity'][$date])){
    $user_json['activity'] =  array(
        "cnum"=>$user_json['activity']['cnum'],
        $date=>array(
            "date"=>$date,
            0=>array(
                "room"=>$_GET['room'],
                "timeDep"=>$time1,
                "timeArv"=>$time2
            )
        )
    );
    write_json($user_json, "registered_phid/" . $_COOKIE['phid']);
    header("Location: index.php?room=" . $_GET['room'] . "&page=main");
    exit();
} else{
    $user_json['activity'][$date][$user_json['activity']['cnum'][0]] = array(
        "room"=>$_GET['room'],
        "timeDep"=>$time1,
        "timeArv"=>$time2
    );
    if ($time2 != ""){
        $user_json['activity']['cnum'][0] = $user_json['activity']['cnum'][0] + 1;
    }
    write_json($user_json, "registered_phid/" . $_COOKIE['phid']);
    header("Location: index.php?room=" . $_GET['room'] . "&page=main");
    exit();
}
?>