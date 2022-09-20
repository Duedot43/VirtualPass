<?php

/** 
 * Change a student
 * 
 * PHP version 8.1
 * 
 * @file     /src/accountTools/student/change.php
 * @category Managment
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
require "../../include/modules.php";


$config = parse_ini_file("../../../config/config.ini");
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <title>Change student info</title>
    <meta name="color-scheme" content="dark light">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>';
if (!isset($_GET['user'])) {
    echo "Your user is not set";
    exit();
}
if (!userExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['user']))) {
    echo "That user does not exist!";
    exit();
}
//Auth
if (isset($_COOKIE['adminCookie']) and adminCookieExists($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_COOKIE['adminCookie']))) {
    $user = getUserData($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['user']));
    $apiKey = getApiKeyByUser($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], preg_replace("/[^0-9.]+/i", "", $_GET['user']));
    $apiKeyLevel = authApi($config['sqlUname'], $config['sqlPasswd'], $config['sqlDB'], $apiKey[1])[1];
    if (isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST['stid']) and isset($_POST['stem']) and sanatizeUser(array("", "", "", $_POST['stem']))[3] and isset($_POST['level'])) {
        $userInfo = sanatizeUser(array($_POST['firstname'], $_POST['lastname'], $_POST['stid'], $_POST['stem']));
        $userInfo[3] = $_POST['stem'];
        $output = array();
        $output[0] = sendSqlCommand(
            "UPDATE users 
        SET 
            firstName = '" . $userInfo[0] . "'
        WHERE
            sysId=" . preg_replace("/[^0-9.]+/i", "", $_GET['user']) . ";",
            $config['sqlUname'],
            $config['sqlPasswd'],
            $config['sqlDB']
        )[0];
        $output[1] = sendSqlCommand(
            "UPDATE users 
        SET 
            lastName = '" . $userInfo[1] . "'
        WHERE
            sysId=" . preg_replace("/[^0-9.]+/i", "", $_GET['user']) . ";",
            $config['sqlUname'],
            $config['sqlPasswd'],
            $config['sqlDB']
        )[0];
        $output[2] = sendSqlCommand(
            "UPDATE users 
        SET 
            id = '" . $userInfo[2] . "'
        WHERE
            sysId=" . preg_replace("/[^0-9.]+/i", "", $_GET['user']) . ";",
            $config['sqlUname'],
            $config['sqlPasswd'],
            $config['sqlDB']
        )[0];
        $output[3] = sendSqlCommand(
            "UPDATE users 
        SET 
            email = '" . $userInfo[3] . "'
        WHERE
            sysId=" . preg_replace("/[^0-9.]+/i", "", $_GET['user']) . ";",
            $config['sqlUname'],
            $config['sqlPasswd'],
            $config['sqlDB']
        )[0];
        $output[4] = sendSqlCommand(
            "UPDATE apiKeys 
        SET 
            perms = '" . $_POST['level'] . "'
        WHERE
            apiKey=" . $apiKey[1] . ";",
            $config['sqlUname'],
            $config['sqlPasswd'],
            $config['sqlDB']
        )[0];
        if (in_array(1, $output)) {
            echo "Something has gone wrong!";
            exit();
        } else {
            echo "User changed succesfully!";
            exit();
        }
        //TODO change time allowed out of room
    }
} else {
    if (isset($_COOKIE['adminCookie'])) {
        header("Location: /admin/");
        exit();
    } else {
        header("Location: /teacher/");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/style.css" type="text/css" />
    <link rel="icon" href="/public/favicon.ico" />
</head>

<body>
    <div class="l-card-container">

        <a>Change the user </a>
        <hr />

        <form method="post">
            <label>
                First Name:
                <!-- deepcode ignore XSS: Its an SQL database please shut up -->
                <input type="text" pattern="[a-zA-Z]+" name="firstname" id="firstname" value="<?php echo $user['firstName']; ?>" required />
                Last Name:
                <!-- deepcode ignore XSS: Its an SQL database please shut up -->
                <input type="text" name="lastname" id="lastname" value="<?php echo $user['lastName']; ?>" required />
                Student ID:
                <!-- deepcode ignore XSS: Its an SQL database please shut up -->
                <input type="number" name="stid" id="stid" value="<?php echo $user['ID']; ?>" required />
                Student Email:
                <!-- deepcode ignore XSS: Its an SQL database please shut up -->
                <input type="email" name="stem" id="stem" value="<?php echo $user['email']; ?>" required>

                <label for="level">API Key level</label>
                <select name="level" id="level">
                    <option value="0" <?php echo (int) $apiKeyLevel === 0 ? "selected" : "" ?> >0</option>
                    <option value="1" <?php echo (int) $apiKeyLevel === 1 ? "selected" : "" ?> >1</option>
                    <option value="2" <?php echo (int) $apiKeyLevel === 2 ? "selected" : "" ?> >2</option>
                    <option value="3" <?php echo (int) $apiKeyLevel === 3 ? "selected" : "" ?> >3</option>
                </select>
            </label>
            <button type="submit" name="Submit" value="Submit"> Submit </button>

        </form>
    </div>

</body>

</html>