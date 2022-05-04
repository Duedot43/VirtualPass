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
$room_sub = $_POST["room"];
$mass_json = json_decode(file_get_contents("../../mass.json"), true);
foreach ($mass_json['room'] as $room_id){
  $real_room = file_get_contents("../registerd_qrids/" . $room_id);
  if ($room_sub == $real_room){
    header("Location: /human_info/teacher_portal/" . $room_id . ".php");
    exit();
  }
}
echo "That room does not exiest!";
exit();
?>