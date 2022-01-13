
<?php 
echo "ay so php is mean so could you type this number";
echo "\ninto the text box to the right so";
echo "\ni can put this dumb thing in a text file", $_GET['page'];
file_put_contents('qrid.txt', $qrid);
?> 
<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="form" method="post" action="stupid.php" method="get">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td colspan="3"><strong>PHP sucks </strong></td>
</tr>
<tr>
<td width="78">THE number</td>
<td width="6">:</td>
<td width="294"><input name="qrid" type="text" id="qrid"></td>
</tr>
<tr>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Submit"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>