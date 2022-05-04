<?php
function room($id, $file_location){
    if (!file_exists($file_location)){
        $main_file_array = array(
            "room" => array(
            ),
            "user" => array(
            )
        );
    } else{
        $main_file_array = json_decode(file_get_contents($file_location), true);
    }
    array_push($main_file_array['room'], $id);
    $json_out = fopen($file_location, "w");
    fwrite($json_out, json_encode($main_file_array));
}
function user($id, $file_location){
    if (!file_exists($file_location)){
        $main_file_array = array(
            "room" => array(
            ),
            "user" => array(
            )
        );
    } else{
        $main_file_array = json_decode(file_get_contents($file_location), true);
    }
    array_push($main_file_array['user'], $id);
    $json_out = fopen($file_location, "w");
    fwrite($json_out, json_encode($main_file_array));
}
?>