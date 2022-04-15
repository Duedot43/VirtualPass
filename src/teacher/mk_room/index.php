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
      header("Location:index.html");
      exit();
  }
}
check_phid($_COOKIE['teacher']);
$ini = parse_ini_file('../../../config/config.ini');
if ($ini['overide_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['overide_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
$page_val = rand();
$url = "https://" . $domain . "/stupid.php?page=" . $page_val;
header("Location: /mk_room/regqrid.php?page=" . $page_val);
?>
<title>Make a room!</title>
