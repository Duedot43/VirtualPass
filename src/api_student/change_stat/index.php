<?php
include "../../usr_pre_fls/checks.php";

$json = json_decode(file_get_contents("php://input"), true);
$mass = json_decode(file_get_contents("../../../mass.json"), true);
if ($mass == false){
    echo '{"success":0, "reason":"no_mass", "human_reason":"Mass.json does not exist!"}';
    exit();
}
if (!isset($_SERVER['PHP_AUTH_USER']) and !in_array($_SERVER['PHP_AUTH_USER'], $mass['apiKeys'])){
    echo '{"success":0, "reason":"invalid_auth", "human_reason":"Your API key is incorrect"}';
    exit();
}
$user = $mass[$_SERVER['PHP_AUTH_USER']];
$user_json = json_decode(file_get_contents("../../registered_phid/" . $user), true);


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
    write_json($user_json, "../../registered_phid/" . $user);
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
    write_json($user_json, "../../registered_phid/" . $user);
    exit();
}
?>