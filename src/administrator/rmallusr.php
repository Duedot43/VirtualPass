<?php
exec("rm ../departed/* && echo p > ../departed/.placeholder");
exec("rm ../registered_phid/* && echo p > ../registered_phid/.placeholder");
echo("Done!");

?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<input type="button" value="Back to Main Menu" onclick="location='menu.php'" />