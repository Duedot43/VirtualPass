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
if ($installed_json[$plugin_id] == 1){
    for ($x = 0; $x <= $selected_plugin['changed']; $x++){
        //uninstall the plugin
        $plugin_file = fopen("../../.." . $selected_plugin['location'][$x], "w");
        fwrite($plugin_file, file_get_contents($selected_plugin['orig_url'][$x]));
        fclose($plugin_file);
        $installed_json[$plugin_id] = 0;
        $plugin_index_file = fopen("../../usr_pre_fls/plugins.json", "w");
        fwrite($plugin_index_file, json_encode($installed_json));
        fclose($plugin_index_file);
        echo "Plugin uninstalled!";
    }
} else{
    if ($selected_plugin['setup'] != "None" and $_GET['setup'] == 0){
        $setup_file = fopen("./setup.php", "w");
        fwrite($setup_file, file_get_contents($selected_plugin['setup']));
        fclose($setup_file);
        header("Location: /administrator/plugin_manager/setup.php?plugin=" . $plugin_id);
        exit();
    }
    for ($x = 0; $x <= $selected_plugin['changed']; $x++){
        //install the plugin
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
unset($plugin_index); unset($selected_plugin);
?>