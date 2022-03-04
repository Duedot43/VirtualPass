<?php
//really delete the user
$cookie_name = "phid";
if(isset($_COOKIE[$cookie_name])){
    if (!is_dir("registered_phid/" . $_COOKIE[$cookie_name])){
        exec("rm -rf departed/" . $_COOKIE[$cookie_name]);
        exec("rm -rf registered_phid/" . $_COOKIE[$cookie_name]);
        setcookie("phid", "", time() - 9999999999);
    }echo("Internal server error your file is not here! please try again...");

} else{
    echo("Internal server error your cookie is not here! please try again...");
}

?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<title>Bye!</title>
User removed.
