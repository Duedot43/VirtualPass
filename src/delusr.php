<?php
//really delete the user
function check_phid($pid){
    if (is_numeric($pid)){
    }
    else{
      echo("Invalid!");
      
      exit();
    }
  }
$cookie_name = "phid";
if(isset($_COOKIE[$cookie_name])){
    check_phid($_COOKIE[$cookie_name]);
    if (file_exists("registered_phid/" . $_COOKIE[$cookie_name])){
        copy("registered_phid/" . $_COOKIE[$cookie_name], "human_info/" . $_COOKIE[$cookie_name] . "/archived_ini");
        unlink("registered_phid/" . $_COOKIE[$cookie_name]);
        $main_json = json_decode(file_get_contents("../mass.json"), true);
        $main_json['user'] = \array_diff($main_json['user'], [$_COOKIE[$cookie_name]]);
        array_push($main_json['removed'], $_COOKIE[$cookie_name]);
        $json_out = fopen("../mass.json", "w");
        fwrite($json_out, json_encode($main_json));
        fclose($json_out);
        setcookie("phid", "", time() - 9999999999);
    }else{
        echo("Internal server error your file is not here! please try again...");
    }
} else{
    echo("Internal server error your cookie is not here! please try again...");
}

?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<title>Bye!</title>
User removed.
