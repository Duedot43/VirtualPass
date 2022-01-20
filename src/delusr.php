<?php
$cookie_name = "phid";
exec("rm departed/" . $_COOKIE[$cookie_name]);
exec("rm registered_phid/" . $_COOKIE[$cookie_name]);
setcookie("phid", "", time() - 9999999999);
echo ("User Removed.")
?>