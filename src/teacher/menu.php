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
        header("Location:index.html");
        exit();
    }
  }
  check_phid($_COOKIE['teacher']);
$ini = parse_ini_file('../../config/config.ini');
$sendemail = $ini['em_enable'];
if ($sendemail == "1"){
    $enable_email = "Disable Emails";
}
if ($sendemail == "0"){
    $enable_email = "Enable Emails";
}
if ($ini['updates'] == 1){
    //This is an option for updates the update server is in the repo vp-update not really a good feture so im just gonna leave it off by default
$remote_release = file_get_contents("https://85c5-8-48-134-44.ngrok.io/latest");
$remote_merge_info = "https://85c5-8-48-134-44.ngrok.io/release_folder/merge-info";
$remote_merge_info_ini = parse_ini_file($remote_merge_info);
$merge = parse_ini_file("../../merge-info");
if ($remote_release != $merge['release']){
    echo('<input class="reg" type="button" value="Update from ' . $merge['release'] . ' to ' . $remote_release . '" onclick="location=\'update.php\'" />');
}
}
?>
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Teacher portal</title>
<input class="reg" type="button" value="Make your room" onclick="location='/teacher/mk_room/index.php'" />
<input class="reg" type="button" value="Look for your room" onclick="location='/teacher/search.html'" />
