<?php 
if ($_GET['page'] == "") {
    echo("invalid URL");
    exit();
}
//echo "TYPE THIS NUMBER IN THE BOX >>> ", $_GET['page'];
exec("rm qrid.txt && echo " . $_GET['page'] . " > qrid.txt");
header("Location: /stupid.php?page=" . $_GET['page']);
exit()
?>