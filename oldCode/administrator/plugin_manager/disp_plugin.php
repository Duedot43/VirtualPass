<?php
/*
MIT License

Copyright (c) 2022 Jack Gendill

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/
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
if (!isset($installed_json[$plugin_id]) or $installed_json[$plugin_id] == 0){
  $install = "Install";
} else{
  $install = "Uninstall";
}
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
<td width="294"><input class="reg" type="button" value="View code" onclick="location='<?php echo $selected_plugin['clone_url']['0']?>'"/></td>
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
