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
include "api/modules.php";
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
        $student = readJson("registered_phid/" . $_COOKIE['phid']);
        $mass = readJson("../mass.json");
        unlink("registered_phid/" . $_COOKIE['phid']);
        unset($mass['user'][$_COOKIE['phid']]);
        $mass['removed'][$_COOKIE['phid']] = $student;
        file_put_contents("../mass.json", json_encode($mass));
        setcookie("phid", "", time() - 9999999999);
    }else{
        echo("Internal server error your file is not here! please try again...");
        exit();
    }
} else{
    echo("Internal server error your cookie is not here! please try again...");
    exit();
}

?>
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
</head>
<title>Bye!</title>
User removed.
