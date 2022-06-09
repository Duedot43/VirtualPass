<?php
function check_string($pid, $response){
    if (!is_numeric($pid)){
        echo($response);
        exit();
    }
}
function ck_page(){
    if (!isset($_GET['room'])){
        echo "Room value not set";
        exit();
    }
}
function check_name($num){
if (ctype_alpha($num)) {
    echo("Valid");
} else {
    echo("Invalid name");
    exit();
}
}
?> 