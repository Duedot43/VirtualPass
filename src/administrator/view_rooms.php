<?php
function check_phid($pid){
    if (is_numeric($pid)){
    }
    else{
        echo("Invalid! not numeric");
      
      exit();
    }
  }
if (!isset($_COOKIE['admin'])){
    exec("rm cookie/*");
    header("Location: /administrator/index.html");
    exit();
}
else{
    if (!file_exists("cookie/" . $_COOKIE['admin'])){
        header("Location:index.html");
        exit();
    }
}
check_phid($_COOKIE['admin']);
function border($activity){
    if ($activity == 0){
        return "ff0004";
    }
    if ($activity == 1){
        return "70b8d4";
    }
}
function studentActiv($activ){
    if ($activ == 1){
      return "arrived";
    } else{
      return "departed";
    }
  }
echo '<head>
<link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View rooms</title>';
if (isset($_GET['room']) and is_numeric($_GET['room'])){
    $room_id = $_GET["room"];
    echo '<button class="reg" onclick="location=\'/teacher/mk_room/ck_qrid.php?room=' . $room_id . '\'">Re make a QR code for this room</button>';
    $mass_json = json_decode(file_get_contents("../../mass.json"), true);
    foreach ($mass_json['user'] as $user_id){
        $user_ini = json_decode(file_get_contents("../registered_phid/" . $user_id), true);
        foreach ($user_ini['rooms'] as $user_room_id){
            if ((int) $user_room_id == (int) $room_id){
                $tat = '<input class="reg" type="button" value="' . $user_ini['fname'] . ' ' . $user_ini['lname'] . ' ' . studentActiv($user_ini['student_activ']) . '" onclick="location=\'/human_info/view.php?user=' . $user_id . '\'" style="border-color:' . border($user_ini['student_activ']) . '; color:white"/></td><br>';
                echo $tat;
            }
        }
    }
    exit();
}
$mass = json_Decode(file_get_contents("../../mass.json"), true);
foreach ($mass['room'] as $room_id){
    $room_num = file_get_contents("../registerd_qrids/" . $room_id);
    echo '<button class="reg" onclick="location=\'/administrator/view_rooms.php?room=' . $room_id . '\'">' . $room_num . '</button><br>';
}

?>