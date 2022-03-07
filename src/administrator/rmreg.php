<?php
if (!isset($_COOKIE['admin'])){
    exec("rm cookie/*");
    header("Location:index.html");;
    exit();
}
else{
    $outputz = exec("tree -i --noreport cookie | grep -o " . $_COOKIE['admin']);
    if ($outputz != $_COOKIE['admin']){
        header("Location:index.html");
    }
}
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