<?php
function check_phid($pid){
    if (is_numeric($pid)){
    }
    else{
      echo("Invalid!");
      echo($pid);
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
$rooms = exec("dir ../registerd_qrids/");
echo ("rooms: {$rooms} <br>");
$roomcont = exec("cat ../registerd_qrids/*");
echo ("roomc: {$roomcont} <br>");
?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Portal</title>
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />