<?php
function check_phid($pid){
    if (is_numeric($pid)){
    }
    else{
        echo("Invalid! not numeric");
      
      exit();
    }
  }
if (!isset($_COOKIE['teacher'])){
    exec("rm cookie/*");
    header("Location: /teacher/index.html");
    exit();
}
else{
    if (!file_exists("cookie/" . $_COOKIE['teacher'])){
        header("Location:/teacher/index.html");
        exit();
    }
}
check_phid($_COOKIE['teacher']);
function border($activity){
  if ($activity == "Departed"){
    return "ff0004";
  }
  if ($activity == "Arrived"){
    return "70b8d4";
  }
}
$room_id = $_GET["room"];
$mass_json = json_decode(file_get_contents("../../mass.json"), true);
foreach ($mass_json['user'] as $user_id){
  $user_ini = parse_ini_file("../registered_phid/" . $user_id, true);
  foreach ($user_ini['room'] as $user_room_id){
    if ($user_room_id == $room_id){
      $tat = '<link href="/style.css" rel="stylesheet" type="text/css" /><input class="reg" type="button" value="' . $user_ini['usrinfo']['first_name'] . ' ' . $user_ini['usrinfo']['last_name'] . ' ' . $user_ini['usrinfo']['student_activity'] . '" onclick="location=\'/human_info/' . $user_id . '/index.html\'" style="border-color:' . border($user_ini['usrinfo']['student_activity']) . '; color:white"/></td><br>';
      echo $tat;
    }
  }
}
?>