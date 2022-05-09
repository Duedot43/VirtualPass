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
        header("Location:/administrator/index.html");
        exit();
    }
}
check_phid($_COOKIE['admin']);
$plugin_index = json_decode(file_get_contents("https://raw.githubusercontent.com/Duedot43/VirtualPass-Applets/master/index.json"), true);
foreach ($plugin_index['plugins'] as $plugin_key){
    echo '<input class="reg" type="button" value="' . $plugin_key['html_name'] . '" onclick="location=\'/administrator/plugin_manager/disp_plugin.php?plugin=' . $plugin_key['name'] . '\'" />';
}
?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>