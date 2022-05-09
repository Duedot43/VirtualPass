<?php
function auth($uname, $passwd){
    $ini = parse_ini_file('../../config/config.ini');
    $unameck = $ini['teacher_uname'];
    $passwdck = $ini['teacher_passwd'];
    if ($uname == $unameck and $passwd == $passwdck){
        return true;
    } else{
        return false;
    }
}
?>