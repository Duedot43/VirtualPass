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
        header("Location:index.html");
        exit();
    }
}
check_phid($_COOKIE['admin']);
exec("rm ../log/* && echo p > ../log/.placeholder");
exec("rm -rf ../registerd_qrids/* && echo p > ../registerd_qrids/.placeholder");
exec("rm -rf ../registered_phid/* && echo p > ../registered_phid/.placeholder");
exec("rm student.php");
exec("rm cookie/*");
exec("rm -rf ../human_info/*");
exec("echo p >>  ../human_info/.placeholder");
exec("echo p >>  cookie/.placeholder");
exec("mkdir ../human_info/teacher_portal/ && echo p > ../human_info/teacher_portal/.placeholder");
echo("Done!");
?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Portal</title>
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />