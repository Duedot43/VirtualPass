<?php
function check_phid($pid)
{
    if (is_numeric($pid)) {
    } else {
        echo ("Invalid! not numeric");

        exit();
    }
}
if (!isset($_COOKIE['admin'])) {
    exec("rm cookie/*");
    header("Location: /administrator/index.html");
    exit();
} else {
    if (!file_exists("cookie/" . $_COOKIE['admin'])) {
        header("Location:index.html");
        exit();
    }
}
check_phid($_COOKIE['admin']);

function valid_json(array $json)
{
    if (
        isset($json['mass'])
        and isset($json['rooms'])
        and isset($json['plugins'])
        and isset($json['plugin_data'])
        and isset($json['config'])
        and isset($json['history'])
        and isset($json['version'])
        and isset($json['student'])
    ) {
        return true;
    } else {
        return false;
    }
}
function arr2ini(array $array)
{
    $output = "";
    foreach ($array as $key => $config_arr) {
        $output .= "[" . $key . "]" . "\n";
        foreach ($config_arr as $key2 => $value) {
            $output .= $key2 . "=" . $value . "\n";
        }
    }
    return $output;
}
function uninstall_plugin(string $plugin)
{
    $plugin_index = json_decode(file_get_contents("https://raw.githubusercontent.com/Duedot43/VirtualPass-Applets/master/index.json"), true);
    $selected_plugin = $plugin_index[$plugin];
    for ($x = 0; $x <= $selected_plugin['changed']; $x++) {
        //uninstall the plugin
        if ($selected_plugin['orig_url'][$x] != "None") {
            $plugin_file = fopen("../.." . $selected_plugin['location'][$x], "w");
            fwrite($plugin_file, file_get_contents($selected_plugin['orig_url'][$x]));
            fclose($plugin_file);
        }
    }
    for ($a = 0; $a <= $selected_plugin['to_remove_file']; $a++) {
        if ($selected_plugin['remove_file'][$a] != "None") {
            unlink("../.." . $selected_plugin['remove_file'][$a]);
        }
    }
    for ($a = 0; $a <= $selected_plugin['to_remove_dir']; $a++) {
        if ($selected_plugin['remove_dir'][$a] != "None") {
            rmdir("../.." . $selected_plugin['remove_dir'][$a]);
        }
    }
}
function install_plugin(string $plugin)
{
    $plugin_index = json_decode(file_get_contents("https://raw.githubusercontent.com/Duedot43/VirtualPass-Applets/master/index.json"), true);
    $selected_plugin = $plugin_index['plugins'][$plugin];
    for ($x = 0; $x <= $selected_plugin['changed']; $x++) {
        //install the plugin
        if ($selected_plugin['clone_url'][$x] != "None") {
            $plugin_file = fopen("../.." . $selected_plugin['location'][$x], "w");
            fwrite($plugin_file, file_get_contents($selected_plugin['clone_url'][$x]));
            fclose($plugin_file);
        }
    }
}
function install_plugin_data(string $plugin, array $plugin_data)
{
    $plugin_data_real = $plugin_data[$plugin];
    foreach ($plugin_data_real as $plugin_arr){
        file_put_contents($plugin_arr['data'], json_encode($plugin_arr['data']));
    }
}
function ck_plugin(string $plugin, array $new_plugin, bool $transfer = false, array $data = array())
{
    $current_plugins = json_decode(file_get_contents("../usr_pre_fls/plugins.json"), true);
    if (isset($current_plugins[$plugin]) and $current_plugins[$plugin] == 1) {
        if (!isset($new_plugin[$plugin]) or $new_plugin[$plugin] == 0) {
            //uninstall the plugin
            uninstall_plugin($plugin);
        }
        if (isset($new_plugin[$plugin]) and $new_plugin[$plugin] == 1) {
            //Transfer data
            if ($transfer) {
                install_plugin_data($plugin, $data);
            }
        }
    }
    if (!isset($current_plugins[$plugin]) or $current_plugins[$plugin] == 0) {
        if (!isset($new_plugin[$plugin]) or $new_plugin[$plugin] == 0) {
        }
        if (isset($new_plugin[$plugin]) and $new_plugin[$plugin] == 1) {
           install_plugin($plugin);
        }
    }
}
if (isset($_FILES['fileToUpload']) and $_FILES['fileToUpload']['type'] == "application/octet-stream" or isset($_GET['file'])) {
    if (!isset($_GET['file'])){
        $file = $_FILES["fileToUpload"]["tmp_name"];
        move_uploaded_file($file, "./backup.b64");
        $backup = file_get_contents("./backup.b64");
        unlink("./backup.b64");
    } else{
        $backup = $_GET['file'];
    }
    $backup_json = base64_decode($backup);
    if (!$backup_json) {
        echo "Invalid backup file! ERROR: NOT BASE64 ENCODED";
        exit();
    }
    $backup_arr = json_decode($backup_json, true);
    if ($backup_arr == "NULL") {
        echo "Invalid backup file! ERROR: FILE IS NOT JSON VALID";
        exit();
    }
    if (!valid_json($backup_arr)) {
        echo "Invalid backup file! ERROR: YOU ARE MISSING SOMETHING";
        exit();
    }
    if (file_exists("../../mass.json")){
 		foreach (json_decode(file_get_contents("../../mass.json"), true)['user'] as $student){
        	unlink("../registered_phid/" . $student);
    	}
    	foreach (json_decode(file_get_contents("../../mass.json"), true)['room'] as $room){
        	unlink("../registerd_qrids/" . $room);
    	}
	}
    $time1 = time();
    echo "restoring mass.json...<br>";
    file_put_contents("../../mass.json", json_encode($backup_arr['mass']));
    echo "Restoring mass.json took " . time() - $time1 . " seconds <br>";
    $time = time();
    echo "Restoring student DB...<br>";
    foreach ($backup_arr['student'] as $student_arr) {
        file_put_contents("../registered_phid/" . $student_arr['id'], json_encode($student_arr['arr']));
    }
    echo "Restoring student DB took " . time() - $time . " seconds<br>";
    echo "Restoring config file...";
    $time = time();
    file_put_contents("../../config/config.ini", arr2ini($backup_arr['config']));
    echo "restoring config file took " . time() - $time . " seconds<br>";
    echo "Restoring history file...<br>";
    file_put_contents("../../his.json", json_encode($backup_arr['history']));
    echo "Restoring history file took 0 seconds<br>";
    echo "Checking for installed plugins...<br>";
    $current_plugins = json_decode(file_get_contents("../usr_pre_fls/plugins.json"));
    echo ck_plugin("ck_ver", $backup_arr['plugins']);
    echo ck_plugin("ccsd_auth", $backup_arr['plugins']);
    echo ck_plugin("cart_checkout", $backup_arr['plugins'], true, $backup_arr['plugin_data']);
    echo ck_plugin("com_checkout", $backup_arr['plugins'], true, $backup_arr['plugin_data']);
    echo "backup restored.<br>";
    exit();
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