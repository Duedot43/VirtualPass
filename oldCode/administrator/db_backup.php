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
$backup_arr = array();
if (!file_exists("../../mass.json")){
    echo "You do not have a DB to back up!";
    exit();
}
$mass = json_decode(file_get_contents("../../mass.json"), true);
$backup_arr['mass'] = $mass;
foreach ($mass['user'] as $user_id){
    $student_arr = json_decode(file_get_contents("../registered_phid/" . $user_id), true);
    $backup_arr['student'][$user_id] = array("arr"=>$student_arr,"id"=>$user_id);
}
foreach ($mass['room'] as $room_id){
    $room_num = file_get_contents("../registerd_qrids/" . $room_id);
    $backup_arr['rooms'][$room_id] = array("num"=>$room_num,"id"=>$room_id);
}
$plugins = json_decode(file_get_contents("../usr_pre_fls/plugins.json"), true);
$backup_arr['plugins'] = $plugins;
$backup_arr['plugin_data'] = array();
if (isset($plugins['cart_checkout']) and $plugins['cart_checkout'] == 1){
    $backup_arr['plugin_data']['cart_checkout']['com_index'] = array(
        "location"=>"/com_config/com_index.json",
        "data"=>json_decode(file_get_contents("../../com_config/com_index.json"), true)
    );
    $backup_arr['plugin_data']['cart_checkout']['auth'] = array(
        "location"=>"/com_config/auth.json",
        "data"=>json_decode(file_get_contents("../../com_config/auth.json"), true)
    );
}
if (isset($plugins['com_checkout']) and $plugins['com_checkout'] == 1){
    $backup_arr['plugin_data']['com_checkout']['dev_index'] = array(
        "location"=>"/dev_config/dev_index.json",
        "data"=>json_decode(file_get_contents("../../dev_config/dev_index.json"), true)
    );
    $backup_arr['plugin_data']['com_checkout']['auth'] = array(
        "location"=>"/dev_config/auth.json",
        "data"=>json_decode(file_get_contents("../../dev_config/auth.json"), true)
    );
}
$backup_arr['config'] = parse_ini_file("../../config/config.ini", true);
$backup_arr['history'] = json_decode(file_get_contents("../../his.json"), true);
$backup_arr['version'] = json_decode(file_get_contents("../../version-info"), true)['current_version'];
$backup_b64 = base64_encode(json_encode($backup_arr, JSON_PRETTY_PRINT));

?>
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Backup VirtualPass</title>
<button onclick="download('<?php echo time(); ?>_backup.vp', '<?php echo $backup_b64 ?>');"'>Download backup file</button><br>
<button onclick="location='https://duedot43.github.io/VirtualPass-Webpage/Editor/Backup/?file=<?php echo $backup_b64 ?>'">Edit and Apply Backup Now</button><br>
<button onclick="location='/administrator/backups/index.php?file=<?php echo $backup_b64 ?>'" >Store Backup Internally</button>
<script>
function download(filename, textInput) {

var element = document.createElement('a');
element.setAttribute('href','data:text/plain;charset=utf-8, ' + encodeURIComponent(textInput));
element.setAttribute('download', filename);
//document.body.appendChild(element);
element.click();
//document.body.removeChild(element);
}

</script>