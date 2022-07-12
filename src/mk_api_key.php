<?php
include "api/modules.php";


if (isset($_COOKIE['phid']) and is_numeric($_COOKIE['phid']) and file_exists("registered_phid/" . $_COOKIE['phid']) and file_exists("../mass.json")){
    $mass = readJson("../mass.json");
    $key = uniqid(rand()) . uniqid(rand());
    $mass['apiKeys'][$key] = $_COOKIE['phid'];
    file_put_contents("../mass.json", $mass);
    echo "Your API key is " . $key;
    exit();
} else{
    echo "Your user does not exist or mass.json does not exist";
    exit();
}
?>