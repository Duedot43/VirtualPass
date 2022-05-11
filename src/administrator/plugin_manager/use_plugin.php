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
    exec("rm ../cookie/*");
    header("Location: /administrator/index.html");
    exit();
}
else{
    if (!file_exists("../cookie/" . $_COOKIE['admin'])){
        header("Location:/administrator/index.html");
        exit();
    }
}
check_phid($_COOKIE['admin']);
$plugin_id = $_GET['plugin'];
$plugin_index = json_decode(file_get_contents("https://raw.githubusercontent.com/Duedot43/VirtualPass-Applets/master/index.json"), true);
$selected_plugin = $plugin_index['plugins'][$plugin_id];
$installed_json = json_decode(file_get_contents("../../usr_pre_fls/plugins.json"), true);
$version_json = json_decode(file_get_contents("../../../version-info"), true);
if ($installed_json[$plugin_id] == 1){
    for ($x = 0; $x <= $selected_plugin['changed']; $x++){
        //uninstall the plugin
        if ($selected_plugin['orig_url'][$x] != "None"){
            $plugin_file = fopen("../../.." . $selected_plugin['location'][$x], "w");
            fwrite($plugin_file, file_get_contents($selected_plugin['orig_url'][$x]));
            fclose($plugin_file);
        }
    }
    for ($a = 0; $a <= $selected_plugin['to_remove_file']; $a++){
        if ($selected_plugin['remove_file'][$a] != "None"){
            unlink("../../.." . $selected_plugin['remove_file'][$a]);
        }
    }
    for ($a = 0; $a <= $selected_plugin['to_remove_dir']; $a++){
        if ($selected_plugin['remove_dir'][$a] != "None"){
            rmdir("../../.." . $selected_plugin['remove_dir'][$a]);
        }
    }
    $installed_json[$plugin_id] = 0;
    $plugin_index_file = fopen("../../usr_pre_fls/plugins.json", "w");
    fwrite($plugin_index_file, json_encode($installed_json));
    fclose($plugin_index_file);
    echo "Plugin uninstalled!";
} else{
    if (!in_array($version_json['current_version'], $selected_plugin['valid_ver'], true)){
        echo "This plugin is not compatiable with your version of VirtualPass";
        exit();
    }
    if ($selected_plugin['setup'] != "None" and $_GET['setup'] == 0){
        mkdir("./tmp");
        $setup_file = fopen("./tmp/setup.php", "w");
        fwrite($setup_file, file_get_contents($selected_plugin['setup']));
        fclose($setup_file);
        header("Location: /administrator/plugin_manager/tmp/setup.php?plugin=" . $plugin_id);
        exit();
    } else{
        if (is_dir("./tmp")){
            unlink("./tmp/setup.php");
            rmdir("./tmp");
        }
    }
    for ($x = 0; $x <= $selected_plugin['changed']; $x++){
        //install the plugin
        if ($selected_plugin['clone_url'][$x] != "None"){
            $plugin_file = fopen("../../.." . $selected_plugin['location'][$x], "w");
            fwrite($plugin_file, file_get_contents($selected_plugin['clone_url'][$x]));
            fclose($plugin_file);
            $installed_json[$plugin_id] = 1;
            $plugin_index_file = fopen("../../usr_pre_fls/plugins.json", "w");
            fwrite($plugin_index_file, json_encode($installed_json));
            fclose($plugin_index_file);
            echo "Plugin installed!";
        }
    }
}
unset($plugin_index); unset($selected_plugin);
?>