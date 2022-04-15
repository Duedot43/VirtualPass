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
        header("Location:index.html");
        exit();
    }
  }
  check_phid($_COOKIE['teacher']);
$ini = parse_ini_file('../../config/config.ini');
$sendemail = $ini['em_enable'];
//exec($sendemail);
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
<title>Admin Portal</title>
<!DOCTYPE html>
<input class="reg" type="button" value="Look for your room" onclick="location='/teacher/search.html'" />