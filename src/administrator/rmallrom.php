<?php
exec("rm -rf ../registerd_qrids/* && echo p > ../registerd_qrids/.placeholder");
echo("Done!");

?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Portal</title>
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />