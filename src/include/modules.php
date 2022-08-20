<?php
function parseCsv(string $file) {
    $csvAsArray = array_map('str_getcsv', file("/home/syntax/Downloads/exportUsers_2022-8-19.csv"));
    return $csvAsArray;
}
function getDomain()
{
    return $_SERVER['host'];
}

function sendSqlCommand($command, $uname, $passwd, $db)
{
    $srvName = "localhost";
    try{
        $conn = new mysqli($srvName, $uname, $passwd, $db);
        $result = $conn->query($command);
    }
    catch(Exception $error) {
        return [1, $error->getMessage()];
    }
    $conn->close();
    return [0, $result];
}
function sendSqlCommandRaw($command, $uname, $passwd)
{
    $srvName = "localhost";

    try{
        $conn = new mysqli($srvName, $uname, $passwd);
        $result = $conn->query($command);
    }
    catch(Exception $error) {
        return [1, $error->getMessage()];
    }
    $conn->close();
    return [0, $result];
}
class user
{
    public array $uInfo;
    function read()
    {
        $userId = $this->uInfo['sysId'];
    }
    // Set the users info
    public function install()
    {
    }
}
$csvAsArray = array_map('str_getcsv', file("/home/syntax/Downloads/exportUsers_2022-8-19.csv"));
print_r($csvAsArray);
?>