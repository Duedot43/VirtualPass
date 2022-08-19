<?php

function read(string $file, string $format = "raw"){
    if ($format == "json"){
        $output = json_decode(file_get_contents($file), true);
        return $output;
    } elseif ($format = "raw") {
        $output = file_get_contents($file);
        return $output;
    }

}

class user {
    //what do to on start?
    public function __construct() {
        
    }
}