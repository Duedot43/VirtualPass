<?php
//nooooo this code is not stolen fron StackOverflow no never!
function config_set($config_file, $section, $key, $value) {
    $config_data = parse_ini_file($config_file, true);
    $config_data[$section][$key] = $value;
    $new_content = '';
    foreach ($config_data as $section => $section_content) {
        $section_content = array_map(function($value, $key) {
            return "$key=$value";
        }, array_values($section_content), array_keys($section_content));
        $section_content = implode("\n", $section_content);
        $new_content .= "[$section]\n$section_content\n";
    }
    file_put_contents($config_file, $new_content);
}
//nooooo this code is not stolen fron StackOverflow no never!
function check_phid($pid){
    if (is_numeric($pid)){
    }
    else{
        echo("Invalid! not numeric");
      
      exit();
    }
  }
if (!isset($_COOKIE['admin'])){
    exec("rm cookie/*");
    header("Location: /administrator/index.html");
    exit();
}
else{
    if (!file_exists("cookie/" . $_COOKIE['admin'])){
        header("Location:index.html");
        exit();
    }
}
check_phid($_COOKIE['admin']);
$ini = parse_ini_file('../../config/config.ini');
$sendemail = $ini['em_enable'];
if ($sendemail == "1"){
    config_set("../../config/config.ini", "email_function", "em_enable", "0");
    echo('<link href="style.css" rel="stylesheet" type="text/css" /> Done! User emails disabled<br>');
}
if ($sendemail == "0"){
    config_set("../../config/config.ini", "email_function", "em_enable", "1");
    echo('<link href="style.css" rel="stylesheet" type="text/css" /> Done! User emails are now enabled<br>you can find them in the users folder under the emails direcory<br> !WARNING! THIS IS A BETA FETURE<br>');
}

?>
<link href="style.css" rel="stylesheet" type="text/css" />
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />