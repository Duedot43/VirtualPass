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
?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Portal</title>
<input type="button" value="View rooms registered" onclick="location='rmreg.php'" />
<input type="button" value="View users registered" onclick="location='ureg.php'" />
<input type="button" value="View logs" onclick="location='inoutlog.php'" />
<input type="button" value="Remove all users" onclick="location='rmallusr.php'" />
<input type="button" value="Remove all rooms" onclick="location='rmallrom.php'" />
<input type="button" value="Remove all logs" onclick="location='rmalllog.php'" />
<input type="button" value="Clean server" onclick="location='clean.php'" />
<input type="button" value="View all user info" onclick="location='student.php'" />