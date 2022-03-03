<?php
exec("rm -rf ../departed/* && echo p > ../departed/.placeholder");
exec("rm -rf ../registered_phid/* && echo p > ../registered_phid/.placeholder");
echo("Done!");

?>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Portal</title>
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />