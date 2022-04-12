<?php
if(isset($_GET['user'])){
    $user = $_GET['user'];
    unlink("registered_phid/" . $user);
    setcookie("phid", "", time() - 9999999999);
    echo ('<link href="style.css" rel="stylesheet" type="text/css" />Done!');
} else{
    echo ('<link href="style.css" rel="stylesheet" type="text/css" />Hmm something is wrong you do not have a valid ammount of info in your URL please try again');
}

?>