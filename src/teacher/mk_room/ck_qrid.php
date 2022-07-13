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
$ini = parse_ini_file('../../../config/config.ini');
if ($ini['override_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['override_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
$page_val = $_GET['room'];
$url = "https://" . $domain . "/do_activ.php?room=" . $page_val . "&page=main";
echo("Please click the download QR code button to download the QR code " . $page_val . "<br>")
?>
<title>Make a room!</title>
<?php echo $url; ?>
<!-- (A) LOAD QRCODEJS LIBRARY -->
<!-- https://cdnjs.com/libraries/qrcodejs -->
<!-- https://github.com/davidshimjs/qrcodejs -->
<script src="/mk_room/qrcode.min.js"></script>

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