<?php
if (!isset($_COOKIE['admin'])){
    exec("rm cookie/*");
    header("Location: /administrator/index.html");
    exit();
}
else{
    if (!file_exists("cookie/" . $_COOKIE['admin'])){
        $inifl = fopen("cookie/" . $_COOKIE['admin'], "r");
        $id = fread($inifl);
        fclose($inifl);
        if ($id != $_COOKIE['admin']){
            header("Location:index.html");
            exit();
        }
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
exec("rm -rf ../registerd_qrids/* && echo p > ../registerd_qrids/.placeholder");
echo("Done!");

?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Portal</title>
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />