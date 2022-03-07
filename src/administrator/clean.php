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
include("rmalllog.php");
include("rmallrom.php");
include("rmallusr.php");
exec("rm student.html");
echo("Done!");
?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Portal</title>
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />