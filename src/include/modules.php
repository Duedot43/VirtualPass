<?php
function config(string $config){
    //im lazy
    return parse_ini_file($config);
}

class user {
    public array $uInfo;
    function read() {
        $userId = $this->uInfo['sysId'];
    }
    // Set the users info
    public function install() {

    }
}