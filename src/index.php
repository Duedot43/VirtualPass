<?php 
function check_qrid($num){
    if (!filter_var($num, FILTER_VALIDATE_INT) === false) {
        echo("Valid");
    } else {
        echo("Invalid");
        
        exit();
    }
  }
if (!isset($_GET['page'])) {
    echo("invalid URL. Redirecting...");
    header("Location: https://github.com/Duedot43/VirtualPass/blob/master/example.link");
    exit();
}
//echo "TYPE THIS NUMBER IN THE BOX >>> ", $_GET['page'];
//exec("rm qrid.txt && echo " . $_GET['page'] . " > qrid.txt");
//pass it on pass it on
check_qrid($_GET['page']);
header("Location: /stupid.php?page=" . $_GET['page']);
exit()
?>