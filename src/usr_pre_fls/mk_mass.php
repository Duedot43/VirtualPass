<?php
/*
MIT License

Copyright (c) 2022 Jack Gendill

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/
function room($id, $file_location){
    if (!file_exists($file_location)){
        $main_file_array = array(
            "room" => array(
            ),
            "user" => array(
            ),
            "removed" => array(
            )
        );
    } else{
        $main_file_array = json_decode(file_get_contents($file_location), true);
    }
    array_push($main_file_array['room'], $id);
    $json_out = fopen($file_location, "w");
    fwrite($json_out, json_encode($main_file_array));
    fclose($json_out);
}
function user($id, $file_location){
    if (!file_exists($file_location)){
        $main_file_array = array(
            "room" => array(
            ),
            "user" => array(
            ),
            "removed" => array(
            )
        );
    } else{
        $main_file_array = json_decode(file_get_contents($file_location), true);
    }
    array_push($main_file_array['user'], $id);
    $json_out = fopen($file_location, "w");
    fwrite($json_out, json_encode($main_file_array));
    fclose($json_out);
}
?>