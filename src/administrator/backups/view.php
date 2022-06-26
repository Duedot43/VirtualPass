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
    exec("rm ../cookie/*");
    header("Location: /administrator/index.html");
    exit();
}
else{
    if (!file_exists("../cookie/" . $_COOKIE['admin'])){
        header("Location:/administrator/index.html");
        exit();
    }
}
check_phid($_COOKIE['admin']);
echo '<head>
<link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View backups</title>';
$mass = json_decode(file_get_contents("../../../mass.json"), true);
foreach ($mass['backups'] as $backupArr){
    $date = explode("_", $backupArr['name']);
    $dateHuman = date("Y/m/d", (int) $date[0]);
    echo "<button class='reg' onclick='location=\"/administrator/db_restore.php?file=" . $backupArr['cont'] . "\"'>Restore backup taken on " . $dateHuman . "</button>";
}

?>