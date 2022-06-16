<?php
//this page has 3 modes; Normal Teacher and Administrator
//It should have a login option for teacher and administrator teacher will redirect to the normal teacher portal 
//The admin login will "unlock" special info that are not normally displayed on the home page


//NORMAL PAGE
//users registered 
//rooms registered



//ADMINISSTRATOR PAGE
//option to redirect to the normal admin portal (If you feel like it you could redo that? or just intigrate it in here?)
//users registered 
//rooms registered
//number of users currently departed
//number of users current arrived
//users departed with a line graph over the day by the hour
//rooms used with a bar graph by the hour
//if there is anything you would like to add feel free and dont worry about the data collection i will get those for you.
if (file_exists("../mass.json")){
    $mass_json = json_decode(file_get_contents("../mass.json"), true);
    $usersReg = count($mass_json['user']);
    $roomsReg = count($mass_json['room']);
    $usersDep = 0;
    $usersArv = 0;
    foreach ($mass_json['user'] as $user){
        $user_arr = json_decode(file_get_contents("registered_phid/" . $user), true);
        if ($user_arr['student_activ'] == 0){
            $usersDep = $usersDep+1;
        }
    }

    foreach ($mass_json['user'] as $user){
        $user_arr = json_decode(file_get_contents("registered_phid/" . $user), true);
        if ($user_arr['student_activ'] == 1){
            $usersArv = $usersArv+1;
        }
    }
}
?>

<!DOCTYPE html>

<html>
    
<head>
<title>Hello World!</title>
    <link href="/style.css" rel="stylesheet" type="text/css" />
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-base.min.js" type="text/javascript"></script>

</head>

<header>
    <div class=navParent>

    <!--
interface.
        <div class="usr">
            Admin
            <button action="">Logout</button>
            <a> </a>

        </div>

        <div class=navChild>

        </div>
-->


    </div>
<body>

    <h1> Hello World! </h1>

    <script>
        var his = <?php if (file_exists("his.json")){
            echo file_get_contents("his.json");
        } else{
            echo "NONE";
        } ?>;
    </script>
    <script src="/usr_pre_fls/chart.js" > </script>
    <div id="freq"></div>

</body>

</html>