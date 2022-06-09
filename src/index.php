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
<title><?php echo $title; //TODO ?></title>
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
