<?php
$ini = parse_ini_file('../../config/config.ini');
if ($ini['overide_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['overide_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
$arrFiles = array();
$handle = opendir('../registerd_qrids');
 
if ($handle) {
    while (($entry = readdir($handle)) !== FALSE) {
        $arrFiles[] = $entry;
    }
}
 
closedir($handle);
if ($arrFiles[1] == "."){
    $page_val = 1;
}
else{
$value = max($arrFiles);
$page_val = $value+1;
}
$url = "https://" . $domain . "/index.php?page=" . $page_val;
echo("Right click the QR code and download it it is current set to qrid " . $page_val . "<br>")
?>
<?php echo $url; ?>
<!-- (A) LOAD QRCODEJS LIBRARY -->
<!-- https://cdnjs.com/libraries/qrcodejs -->
<!-- https://github.com/davidshimjs/qrcodejs -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<!-- (B) GENERATE QR CODE HERE -->
<div id="qrcode"></div>

<!-- (C) CREATE QR CODE ON PAGE LOAD -->
<script>
window.addEventListener("load", () => {
  var qrc = new QRCode(document.getElementById("qrcode"), "<?php echo $url; ?>");
});
</script>