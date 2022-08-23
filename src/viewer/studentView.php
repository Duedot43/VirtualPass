<?php
include "../include/modules.php";
$config = parse_ini_file("../../config/config.ini");
if (!isset($_GET['refer'])) {
    echo "You do not have an authentication system";
    exit();
}
$result = sendSqlCommand("SELECT * FROM users;", "root", $config['sqlRootPasswd'], "VirtualPass");
while($row = mysqli_fetch_assoc($result[1])) {
    print_r($row);
}