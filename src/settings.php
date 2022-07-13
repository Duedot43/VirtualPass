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
include "usr_pre_fls/mk_mass.php";
include "usr_pre_fls/checks.php";
include "api/modules.php";


ck_page();
if (!isset($_COOKIE['phid']) or !file_exists("registered_phid/" . $_COOKIE['phid'])){
    header("Location: /index.php?room=" . $_GET['room'] . "&page=main");
    exit();
}
check_string($_COOKIE['phid'], "Your cookie is invalid");
$user = json_decode(file_get_contents("registered_phid/" . $_COOKIE['phid']), true);
$wtf = "index.php?room=" . $_GET['room'] . "&page=main";
$ids = array("fname", "lname", "id", "email");
if (isset($_POST['fname']) and isset($_POST['lname']) and isset($_POST['id']) and isset($_POST['email'])){
    foreach ($ids as $id_name){
        $user[$id_name] = $_POST[$id_name];
    }
}
if (validUser($user)){
    file_put_contents("registered_phid/" . $_COOKIE['phid'], json_encode($user));
    header("Location: /index.php?room=" . $_GET['room'] . "&page=main");
    exit();
} else{
    echo "Invalid user info";
}
?>

<title>Edit user info</title>
<head>
    <link href="/style.css" rel="stylesheet" type="text/css" />
</head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<tr>
    <form method="post" name="form" action="/settings.php?room=<?php echo $_GET['room']; ?>&page=main">
        <td>
            <table width="100%" border="0" cellpadding="3" cellspacing="1">
                <tr>
                    <td colspan="3"><strong>User info
                            <hr />
                        </strong></td>
                </tr>
                <tr>
                    <td class="text" width="78">Name
                        <td width="6">:</td>
                        <td width="294"><input class="box" name="fname" value="<?php echo $user['fname']; ?>" type="text" id="fname" autocomplete="off" required></td>
                    </td>
                </tr>
                <tr>
                    <td>Last name</td>
                    <td>:</td>
                    <td><input class="box" name="lname" type="text" id="lname" value="<?php echo $user['lname']; ?>" autocomplete="off" required></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><input class="box" name="email" type="email" id="email" value="<?php echo $user['email']; ?>" autocomplete="off" required></td>
                </tr>
                <tr>
                    <td>ID</td>
                    <td>:</td>
                    <td><input class="box" name="id" type="number" id="id" value="<?php echo $user['id']; ?>" autocomplete="off" required></td>
                </tr>
</tr>
<tr>
    <td><input class="reg" type='button' value="Cancel" onclick="location='<?php echo $wtf; ?>'"></td>
    <td>&nbsp;</td>
    <td><input class="reg" type="submit" name="Submit" value="Submit"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>