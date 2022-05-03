<?php
$config = parse_ini_file("../../config/config.ini");
if (isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] == $config['admin_uname']){
    if (isset($_SERVER['PHP_AUTH_PW']) and $_SERVER['PHP_AUTH_PW'] == $config['admin_passwd']){
        echo 1;
        exit();
    }
}
echo 0;
exit();
?>