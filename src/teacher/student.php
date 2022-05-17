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
$room_sub = $_POST["room"];
$mass_json = json_decode(file_get_contents("../../mass.json"), true);
foreach ($mass_json['room'] as $room_id){
  $real_room = file_get_contents("../registerd_qrids/" . $room_id);
  if ($room_sub == $real_room){
    header("Location: /teacher/disp_room.php?room=" . $room_id);
    exit();
  }
}
echo "That room does not exiest!";
exit();
?>