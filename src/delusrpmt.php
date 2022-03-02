<?php
if (isset($_POST['confirm'])) {
    if ($_POST['confirm'] == 'Yes') {
        header("Location:delusr.php");
    }
    else if ($_POST['confirm'] == 'No') {
        header("Location:stupid.php");
    } 
}
?>

<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<tr>
<form method="post">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td colspan="3"><strong>Are you sure you want to delete your user?</strong></td>
</tr>
<tr>
<td width="0"></td>
<td width="0"></td>
<td width="294"><input class="reg" type="submit" name="confirm" value="Yes">
<td width="78"></td>
<td width="80"></td>
<td width="294"><input class="reg" type="submit" name="confirm" value="No">
</tr>
<tr>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>
</tr>
</table>
</td>
</form>
</tr>
</table>
