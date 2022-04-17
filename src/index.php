<?php
$ini = parse_ini_file('../config/config.ini');
if ($ini['overide_automatic_domain_name'] == "1"){
  $domain = $ini['domain_name'];
}
if ($ini['overide_automatic_domain_name'] != "1"){
  $domain = $_SERVER['SERVER_NAME'];
}
?>
</head>
<!-- HTML Meta Tags -->
<title>iuhsdoifgyusoiuyfgaouygbfousygdfoiyasdgtfoaihyusdgfoiuyag</title>
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
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<tr>
<form name="form" method="post" action="regqrid.php" method="get">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td colspan="3"><strong>If you are a student you are in the wrong place!</strong></td>
</tr>
<tr>
<td width=device-width><input class="reg" type="button" value="Teacher portal" onclick="location='/teacher/'" /></td>
</tr>
<tr>
</tr>
<tr>
</tr>
</table>
</td>
</form>
</tr>
</table>
