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
    exec("rm ../../teacher/cookie/*");
    header("Location: /teacher/index.html");
    exit();
}
else{
    if (!file_exists("../../teacher/cookie/" . $_COOKIE['teacher'])){
        header("Location:/teacher/index.html");
        exit();
    }
}
check_phid($_COOKIE['teacher']);
function border($activity){
  if ($activity == "Departed"){
    return "ff0004";
  }
  if ($activity == "Arrived"){
    return "70b8d4";
  }
}
?>