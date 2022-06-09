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
include "usr_pre_fls/mk_mass.php";
include "usr_pre_fls/checks.php";
ck_page();
check_string($_GET['room'], "INVALID ROOM VALUE NOT NUMERIC");
//update the icon!
$icon_json = json_decode(file_get_contents("https://raw.githubusercontent.com/Duedot43/VirtualPass-Applets/master/favicons/index.json"), true);
$plugin_json = json_decode(file_get_contents("usr_pre_fls/plugins.json"), true);
if (!isset($plugin_json['favico'])){
  $plugin_json['favico'] = "1";
}
if ($plugin_json != $icon_json['current_icon']){
  file_put_contents("favicon.ico", file_get_contents("https://raw.githubusercontent.com/Duedot43/VirtualPass-Applets/master/favicons/" . $icon_json['current_icon']. ".ico"));
  $plugin_json['favico'] = $icon_json['current_icon'];
  file_put_contents("usr_pre_fls/plugins.json", json_encode($plugin_json));
}

$ini = parse_ini_file('../config/config.ini');
if ($ini['overide_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['overide_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}


if (!file_exists("registerd_qrids/" . $_GET['room'])){
  header("Location: /regqrid.php?room=" . $_GET['room'] . "&page=main");
  exit();
}


if (!isset($_COOKIE['phid']) or !file_exists("registered_phid/" . $_COOKIE['phid'])){
  header("Location: /registercookie.php?room=" . $_GET['room'] . "&page=main");
  exit();
}


$user_json = json_decode("registered_phid/" . $_COOKIE['phid'], true);


if ($user_json['student_activ'] == 0){
  $dpt = "departed";
} else{
  $dpt = "arrived";
}


if ($user_json['student_activ'] == 1){
  $dpt2 = "departed";
} else{
  $dpt2 = "arrived";
}
?>
</head>
<!-- HTML Meta Tags -->
<title>VirtualPass?></title>
<meta name="description" content="The utility that lets you set up your users with a virtual hall pass for administrators to help keep track of where your emplyees are.">

<!-- Facebook Meta Tags -->
<meta property="og:url" content="https://<?php echo $domain; ?>/">
<meta property="og:type" content="website">
<meta property="og:title" content="VirtualPass">
<meta property="og:description" content="The utility that lets you set up your users with a virtual hall pass for administrators to help keep track of where your emplyees are.">
<meta property="og:image" content="https://<?php echo $domain;?>/Images/preview.png">

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:domain" content="<?php echo $domain;?>">
<meta property="twitter:url" content="https://<?php echo $domain;?>/">
<meta name="twitter:title" content="VirtualPass">
<meta name="twitter:description" content="The utility that lets you set up your users with a virtual hall pass for administrators to help keep track of where your emplyees are.">
<meta name="twitter:image" content="https://<?php echo $domain;?>/Images/preview.png">

<!-- Meta Tags Generated via https://www.opengraph.xyz -->
      
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<tr>
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td colspan="80"><strong>Hall pass registered<br>you have <?php echo $dpt;?><br></strong></td>
</tr>
<tr>
<td width="0"></td>
<td width="0"></td>
<td width="294"><input class="reg" type="button" id="return" value='<?php echo $dpt2;?>' onclick="location='do_activ.php?room='" /></td>
<script>
document.getElementById("return").disabled = true;
document.querySelector('#return').value = '5';
setTimeout(() => { document.querySelector('#return').value = '4'; }, 1000);
setTimeout(() => { document.querySelector('#return').value = '3'; }, 2000);
setTimeout(() => { document.querySelector('#return').value = '2'; }, 3000);
setTimeout(() => { document.querySelector('#return').value = '1'; }, 4000);
setTimeout(() => {  document.getElementById("return").disabled = false; }, 5000);
setTimeout(() => { document.querySelector('#return').value = '<?php echo $dpt2;?>'; }, 5000);
</script>
<td width="78"></td>
<td width="80"></td>
<td width="294"><input class="reg" type="button" value="Delete User Info" onclick="location='delusrpmt.php?room='" style="border-color:97042F; color:white"/></td>
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