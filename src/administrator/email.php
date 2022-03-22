<?php
$sendemail = exec("cat ../../config/user_emails"); 
if ($sendemail == "1"){
    exec("rm ../../config/user_emails && echo 0 >> ../../config/user_emails");
    echo('<link href="style.css" rel="stylesheet" type="text/css" /> Done! User emails disabled');
}
if ($sendemail == "0"){
    exec("rm ../../config/user_emails && echo 1 >> ../../config/user_emails");
    echo('<link href="style.css" rel="stylesheet" type="text/css" /> Done! User emails are now enabled<br>you can find them in the users folder under the emails direcory<br> !WARNING! THIS IS A BETA FETURE');
}

?>
<link href="style.css" rel="stylesheet" type="text/css" />
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />