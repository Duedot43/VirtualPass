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
header("Location: /log/inout.log");
?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<title>Admin Portal</title>