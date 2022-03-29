<?php
if (!isset($_COOKIE['admin'])){
    exec("rm cookie/*");
    header("Location: /administrator/index.html");
    exit();
}
else{
    //$outputz = exec("tree -i --noreport cookie | grep -o " . $_COOKIE['admin']);
    if (!file_exists("cookie/" . $_COOKIE['admin'])){
        header("Location:index.html");
    }
}
$ini = parse_ini_file('../../config/config.ini');
$sendemail = $ini['em_enable'];
//exec($sendemail);
if ($sendemail == "1"){
    $enable_email = "Disable Emails";
}
if ($sendemail == "0"){
    $enable_email = "Enable Emails";
}
?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Portal</title>
<!DOCTYPE html>
<input class="reg" type="button" value="View rooms registered" onclick="location='rmreg.php'" />
<input class="reg" type="button" value="View users registered" onclick="location='ureg.php'" />
<input class="reg" type="button" value="View logs" onclick="location='inoutlog.php'" />
<input class="reg" type="button" value="Remove all users" onclick="location='rmallusr.php'" />
<input class="reg" type="button" value="Remove all rooms" onclick="location='rmallrom.php'" />
<input class="reg" type="button" value="Remove all logs" onclick="location='rmalllog.php'" />
<input class="reg" type="button" value="Clean server" onclick="location='clean.php'" />
<input class="reg" type="button" value="View all user info" onclick="location='student.php'" />
<input class="reg" type="button" value="<?php echo $enable_email?>" onclick="location='email.php'" />