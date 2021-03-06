<?php
include "usr_pre_fls/checks.php";


function snapshot(){
    $config = parse_ini_file("../config/config.ini");
    $shapshot_time = $config['snapshot_time_seconds'];
    if (file_exists("../mass.json")){
        $mass = json_decode(file_get_contents("../mass.json"), true);
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
        $time = time();
        if (file_exists("../his.json")){
            $history = json_decode(file_get_contents("../his.json"), true);
            foreach($history['history'] as $history_arr){
                $last = $history_arr['time'];
            }
        }
        if (!isset($history) or $time-$history['history'][$last]['time'] >= $shapshot_time){
            $history['history'][$time] = array(
                "out"=>$usersDep,
                "in"=>$usersArv,
                "userReg"=>count($mass['user']),
                "roomReg"=>count($mass['room']),
                "time"=>$time
            );
            write_json($history, "../his.json");
        }
    }
}
ck_page();
if (isset($_COOKIE['phid'])){
    check_string($_COOKIE['phid'], "incalid cookie");
}
check_string($_GET['room'], "INVALID ROOM VALUE NOT NUMERIC");
snapshot();
if (!isset($_COOKIE['phid']) or !file_exists("registered_phid/" . $_COOKIE['phid'])){
    if (isset($_GET['room']) and isset($_GET['page'])){
        header("Location: /index.php?room=" . $_GET['room'] . "&page=" . $_GET['page']);
        exit();
    } else{
        header("Location: /");
        exit();
    }
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