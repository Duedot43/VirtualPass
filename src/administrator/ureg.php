<?php
if (!isset($_COOKIE['admin'])){
    exec("rm cookie/*");
    header("Location:index.html");
    exit();
}
else{
    $outputz = exec("tree -i --noreport cookie | grep -o " . $_COOKIE['admin']);
    if ($outputz != $_COOKIE['admin']){
        header("Location:index.html");
    }
}
$rooms = exec("dir ../registered_phid/ && dir ../departed/");
echo ("Users: {$rooms} <br>");
$roomcont = exec("cat ../registered_phid/* && cat ../departed/*");
echo ("Usrinfo: {$roomcont} <br>");
?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Portal</title>
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />