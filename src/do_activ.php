<?php
include "usr_pre_fls/checks.php";


ck_page();
check_string($_GET['room'], "INVALID ROOM VALUE NOT NUMERIC");
if (!isset($_COOKIE['phid'])){
    echo "YOU CANNOT BE HERE WITHOUT A COOKIE!";
    exit();
}

$user_json = json_decode(file_get_contents("registered_phid/" . $_COOKIE['phid']), true);


if ($user_json['student_activ'] == 0){
    $user_json['student_activ'] = 1;
} else{
    $user_json['student_activ'] = 0;
}


$date = date("d") . "/" . date("m") . "/" . date("y");
if ($user_json['activity']['cnum'][0] = $user_json['activity']['cnum'][1] == 1){
    $time1 == time();
    $time2 == "";
    $user_json['activity']['cnum'][0] = $user_json['activity']['cnum'][1] = 2;
} else{
    $time1 == $user_json['activity'][$date][$user_json['activity']['cnum'][0]]['timeDep'];
    $time2 == time();
    $user_json['activity']['cnum'][0] = $user_json['activity']['cnum'][1] = 1;
    $user_json['activity']['cnum'][0] = $user_json['activity']['cnum'][0] = $user_json['activity']['cnum'][0] = $user_json['activity']['cnum'][1] + 1;
}
if (!isset($user_json['activity'][$date])){
    $user_json['activity'] =  array(
        "cnum"=>array(0, 2),
        $date=>array(
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
    write_json($user_json, "registered_phid/" . $_COOKIE['phid']);
    header("Location: index.php?room=" . $_GET['room'] . "&page=main");
    exit();
}
?>