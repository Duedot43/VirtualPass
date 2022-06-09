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
//really delete the user
function check_phid($pid){
    if (is_numeric($pid)){
    }
    else{
      echo("Invalid!");
      
      exit();
    }
  }

if(isset($_COOKIE['phid'])){
    check_phid($_COOKIE['phid']);
    if (file_exists("registered_phid/" . $_COOKIE['phid'])){
        copy("registered_phid/" . $_COOKIE['phid'], "human_info/" . $_COOKIE['phid'] . "/archived_ini");
        unlink("registered_phid/" . $_COOKIE['phid']);
        $main_json = json_decode(file_get_contents("../mass.json"), true);
        $main_json['user'] = \array_diff($main_json['user'], [$_COOKIE['phid']]);
        array_push($main_json['removed'], $_COOKIE['phid']);
        $json_out = fopen("../mass.json", "w");
        fwrite($json_out, json_encode($main_json));
        fclose($json_out);
        setcookie("phid", "", time() - 9999999999);
    }else{
        echo("Internal server error your file is not here! please try again...");
    }
} else{
    echo("Internal server error your cookie is not here! please try again...");
}

?>
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<title>Bye!</title>
User removed.
