<?php
function check_string($pid, $response){
    if (!is_numeric($pid)){
        echo($response);
        exit();
    }
}
function ck_page(){
    if (!isset($_GET['room']) and !is_numeric($_GET['room'])){
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
function write_json($arr, $location){
    $json_encoded = json_encode($arr);
    file_put_contents($location, $json_encoded);
}
function validUser(array $user){
    if(ctype_alpha($user['fname']) and ctype_alpha($user['lname']) and filter_var($user['email'], FILTER_VALIDATE_EMAIL) and is_numeric($user['id'])){
        return true;
    } else{
        echo "The info you entered is invalid";
        return false;
    }
}
?> 