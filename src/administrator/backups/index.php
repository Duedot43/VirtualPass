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
if (!isset($_GET['file']) or !base64_decode($_GET['file']) or !json_decode(base64_decode($_GET['file']))){
    echo "You do not have a file to request";
    exit();
}
$mass = json_decode(file_get_contents("../../../mass.json"), true);
$time = time();
$mass['backups'][$time . "_backup.vp"] = array(
    "name" => $time . "_backup.vp",
    "cont" => $_GET['file']
);
file_put_contents("../../../mass.json" , json_encode($mass));
header("Location: /administrator/backups/view.php");
exit();
?>
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">