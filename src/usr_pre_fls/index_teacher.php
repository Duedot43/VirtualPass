<?php
function check_phid($pid){
    if (is_numeric($pid)){
    }
    else{
        echo("Invalid! not numeric");
      
      exit();
    }
  }
if (!isset($_COOKIE['teacher'])){
    exec("rm cookie/*");
    header("Location: /teacher/index.html");
    exit();
}
else{
    if (!file_exists("cookie/" . $_COOKIE['teacher'])){
        header("Location:/teacher/index.html");
        exit();
    }
}
check_phid($_COOKIE['teacher']);
?>