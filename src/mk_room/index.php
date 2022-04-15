<?php
function check_phid($pid){
  if (is_numeric($pid)){
  }
  else{
      echo("Invalid! not numeric");
    
    exit();
  }
}
if (!isset($_COOKIE['admin'])){
  exec("rm ../administrator/cookie/*");
  header("Location: /administrator/index.html");
  exit();
}
else{
  if (!file_exists("../administrator/cookie/" . $_COOKIE['admin'])){
      header("Location:/administrator/index.html");
      exit();
  }
}
check_phid($_COOKIE['admin']);
$ini = parse_ini_file('../../config/config.ini');
if ($ini['overide_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['overide_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
$arrFiles = array();
$handle = opendir('../registerd_qrids');
 
if ($handle) {
    while (($entry = readdir($handle)) !== FALSE) {
        $arrFiles[] = $entry;
    }
}
 
closedir($handle);
$value = max($arrFiles);
echo($arrFiles[0] . "<br>");
echo($arrFiles[1] . "<br>");
echo($arrFiles[2] . "<br>");
echo($arrFiles[3] . "<br>");
echo($arrFiles[4] . "<br>");
if (!is_integer($value)){
    $page_val = 1;
}
else{
$page_val = $value+1;
}
$url = "https://" . $domain . "/index.php?page=" . $page_val;
//header("Location: /mk_room/regqrid.php?page=" . $page_val);
?>
<title>Make a room!</title>
