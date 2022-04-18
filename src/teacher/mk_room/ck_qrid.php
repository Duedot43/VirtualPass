<?php
function check_phid($pid){
  if (is_numeric($pid)){
  }
  else{
      echo("Invalid! not numeric");
    
    exit();
  }
}
if (!isset($_COOKIE['teacher'])){
  exec("rm ../cookie/*");
  header("Location: /teacher/index.html");
  exit();
}
else{
  if (!file_exists("../cookie/" . $_COOKIE['teacher'])){
      header("Location:/teacher/index.html");
      exit();
  }
}
check_phid($_COOKIE['teacher']);
$ini = parse_ini_file('../../../config/config.ini');
if ($ini['overide_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['overide_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
$page_val = $_GET['page'];
$url = "https://" . $domain . "/stupid.php?page=" . $page_val;
echo("Right click the QR code and download it it is current set to qrid " . $page_val . "<br>")
?>
<title>Make a room!</title>
<?php echo $url; ?>
<!-- (A) LOAD QRCODEJS LIBRARY -->
<!-- https://cdnjs.com/libraries/qrcodejs -->
<!-- https://github.com/davidshimjs/qrcodejs -->
<script src="/mk_room/qrcode.min.js"></script>

<!-- (B) GENERATE QR CODE HERE -->
<div id="qrcode"></div>

<!-- (C) CREATE QR CODE ON PAGE LOAD -->
<script>
window.addEventListener("load", () => {
  var qrc = new QRCode(document.getElementById("qrcode"), "<?php echo $url; ?>");
  const div = document.createElement('div');
  new QRCode(div, "<?php echo $url;?>");
  const src = div.children[0].toDataURL("image/png");
  //console.info('src', src);
});
</script>