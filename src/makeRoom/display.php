<?php

/** 
 * Room maker
 * 
 * PHP version 8.1
 * 
 * @file     /src/makeRoom/display.php
 * @category Room_Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../include/modules.php";
$domain = getDomain();$config = parse_ini_file("../../config/config.ini");
$config = parse_ini_file("../../config/config.ini");
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <title>Download room QR</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>';
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie'])) or isset($_COOKIE['teacherCookie']) and teacherCookieExists("root", $config['sqlRootPasswd'], "VirtualPass", preg_replace("/[^0-9.]+/i", "", $_COOKIE['teacherCookie']))) {
    if (!isset($_GET['id'])) {
        echo "You do not have a room to create";
        exit();
    }
    $url = "https://" . $domain . "/?room=" . htmlspecialchars(preg_replace("/[^0-9.]+/i", "", $_GET['id']),  ENT_QUOTES, 'UTF-8');
    $page_val = htmlspecialchars(preg_replace("/[^0-9.]+/i", "", $_GET['id']),  ENT_QUOTES, 'UTF-8');
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
        exit();
    }
}
?>
<title>Make a room!</title>
<?php echo $url; ?>
<!-- (A) LOAD QRCODEJS LIBRARY -->
<!-- https://cdnjs.com/libraries/qrcodejs -->
<!-- https://github.com/davidshimjs/qrcodejs -->
<script src="/makeRoom/qrcode.min.js"></script>

<!-- (B) GENERATE QR CODE HERE -->
<div id="qrcode"></div>
<a href="" id="dbth" download="<?php echo "room_" . $page_val?>" >Download QR code</a>
<!-- (C) CREATE QR CODE ON PAGE LOAD -->
<script>
window.addEventListener("load", () => {
  var qrc = new QRCode(document.getElementById("qrcode"), "<?php echo $url; ?>");
  const div = document.createElement('div');
  new QRCode(div, "<?php echo $url;?>");
  var thing = div.children[0].toDataURL("image/png");
  document.querySelector('#dbth').href = thing;
});
</script>