<?php
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
$inifl = fopen("cookie/" . $_COOKIE['admin'], "r");
$id = fread($inifl, "200");
fclose($inifl, );
if ($id != $_COOKIE['admin']){
    header("Location:index.html");
    exit();
}
//If you want to try to fix this feture go ahead i dont have the server hardware network or the money to pay for a cool domain name
$remote_release = file_get_contents("https://85c5-8-48-134-44.ngrok.io/latest");
$remote_merge_info = file_get_contents("https://85c5-8-48-134-44.ngrok.io/release_folder/merge-info");
$remote_merge_info_ini = parse_ini_file($remote_merge_info);
$merge = parse_ini_file("../../merge-info");
if ($remote_release != $merge['release']){
    echo("There is no update at this time.");
    exit();
}
if ($remote_merge_info_ini['mergeable'] != 1){
    echo("This release cannot be merged automaticly you must update manualy");
    exit();
}
?>