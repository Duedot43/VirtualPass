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
function check_phid($pid){
    if (is_numeric($pid)){
    }
    else{
      echo("Invalid phid cookie!");
      
      exit();
    }
  }
if(isset($_GET['user'])){
    $user = $_GET['user'];
    check_phid($user);
    unlink("registered_phid/" . $user);
    setcookie("phid", "", time() - 9999999999);
    echo ('<link href="/style.css" rel="stylesheet" type="text/css" />Done!');
} else{
    echo ('<link href="/style.css" rel="stylesheet" type="text/css" />Hmm something is wrong you do not have a valid ammount of info in your URL please try again');
}

?>