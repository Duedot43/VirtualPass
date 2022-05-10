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
if ($installed_json[$plugin_id] == 0){
  $install = "Install";
} else{
  $install = "Uninstall";
}
unset($plugin_index); unset($selected_plugin);
?>
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Install/Remove plugin</title>
<tr>
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td colspan="80"><strong><?php echo $selected_plugin['html_name'];?><br><?php echo $selected_plugin['description'];?></strong></td>
</tr>
<tr>
<td width="0"></td>
<td width="0"></td>
<td width="294"><input class="reg" type="button" id="return" value='<?php echo $install;?>' onclick="location='use_plugin.php?plugin=<?php echo $plugin_id;?>&setup=0'" /></td>
<td width="78"></td>
<td width="80"></td>
<td width="294"><input class="reg" type="button" value="View code" onclick="location='<?php echo $selected_plugin['clone_url']?>'"/></td>
<td width="0"></td>
<td width="0"></td>
</tr>
<tr>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
</td>
</tr>
</table>
