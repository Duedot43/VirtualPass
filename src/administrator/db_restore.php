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

function valid_json(array $json){
    if (isset($json['mass']) and isset($json['mass']['user']) and isset($json['mass']['room']) and isset($json['mass']['removed'])
     and isset($json['rooms'])
     and isset($json['plugins'])
     and isset($json['plugins_data'])
     and isset($json['config'])
     and isset($json['history'])
     and isset($json['version'])
     and isset($json['student'])
    )
    {
        return true;
    } else{
        return false;
    }

}
function arr2ini(array $array){
    $output = "";
    foreach ($array as $key => $config_arr){
        $output .= "[" . $key . "]" . "\n";
        foreach ($config_arr as $key2 => $value){
            $output .= $key2 . "=" . $value . "/n";
        }
    }
    return $output;
}
print_r($_FILES);
if (isset($_FILES['fileToUpload']) and $_FILES['fileToUpload']['type'] == "application/octet-stream"){
    $file = $_FILES["fileToUpload"]["tmp_name"];
    move_uploaded_file($file, "./backup.b64");
    $backup = file_get_contents("./backup.b64");
    unlink("./backup.b64");
    $backup_json = base64_decode($backup);
    if (!$backup_json){
        echo "Invalid backup file! ERROR: NOT BASE64 ENCODED";
        exit();
    }
    $backup_arr = json_decode($backup_json, true);
    if ($backup_arr == "NULL"){
        echo "Invalid backup file! ERROR: FILE IS NOT JSON VALID";
        exit();
    }
    if (!valid_json($backup_arr)){
        echo "Invalid backup file! ERROR: YOU ARE MISSING SOMETHING";
        exit();
    }
    echo arr2ini($backup_arr);
    exit();
    $time1 = time();
    echo "restoring mass.json...<br>";
    file_put_contents(json_encode($backup_arr['mass']), "../../mass.json");
    echo "Restoring mass.json took " . time()-$time1 . " seconds <br>";
    $time = time();
    echo "Restoring student DB...<br>";
    foreach ($backup_arr['student'] as $student_arr){
        file_put_contents(json_encode($student_arr['arr']), "../registered_phid/" . $student_arr['id']);
    }
    echo "Restoring student DB took " . time()-$time . " seconds<br>";
    echo "Restoring config file...";
    $time = time();

}
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Restore</title>
<tr>
    <form method="post" name="form" enctype="multipart/form-data" action="/administrator/db_restore.php">
        <td>
            <table width="100%" border="0" cellpadding="3" cellspacing="1">
                <tr>
                    <td colspan="3"><strong>Upload backup file
                            <hr />
                        </strong></td>
                </tr>
                <tr>
                    <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
                </tr>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input class="reg" type="submit" name="Submit" value="Upload"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>