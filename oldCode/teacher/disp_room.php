<?php
/*
MIT License

Copyright (c) 2022 Jack Gendill

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/
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
<title>View room</title>';
$room_id = $_GET["room"];
$mass_json = json_decode(file_get_contents("../../mass.json"), true);
foreach ($mass_json['user'] as $user_id){
  $user_ini = json_decode(file_get_contents("../registered_phid/" . $user_id), true);
  foreach ($user_ini['rooms'] as $user_room_id){
    if ($user_room_id == $room_id){
      $tat = '<input class="reg" type="button" value="' . $user_ini['fname'] . ' ' . $user_ini['lname'] . ' ' . studentActiv($user_ini['student_activ']) . '" onclick="location=\'/human_info/view.php?user=' . $user_id . '\'" style="border-color:' . border($user_ini['student_activ']) . '; color:white"/></td><br>';
      echo $tat;
    }
  }
}
?>