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
header("Location: /log/inout.log");
?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<title>Admin Portal</title>