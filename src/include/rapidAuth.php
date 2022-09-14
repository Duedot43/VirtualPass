<?php

/** 
 * Auth module for Rapid Identy
 * 
 * PHP version 8.1
 * 
 * @file     /src/include/rapidAuth.php
 * @category Authentication
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */

/**
 * Rapid Identy Authentication
 *
 * @param string $hostname Rapidideity server hostname
 * @param string $uname    Username
 * @param string $passwd   Password

 * @return array
 */
function rapidAuth(string $hostname, string $uname, string $passwd)
{
    $response = json_decode(file_get_contents("https://" . $hostname . "/api/rest/authn"), true);
    $type = $response["type"];
    $id = $response["id"];
    if ($type === "username+password") {
        $userpass = json_encode(array('type' => 'username+password', 'id' => $id, 'username' => $uname, 'password' => $passwd), true);
        $opts = array(
            'http' =>
            array(
                'method'  => 'POST',
                'header'  => "Content-Type: application/json",
                'content' => $userpass
            )
        );
        $context  = stream_context_create($opts);
        $result = json_decode(file_get_contents("https://" . $hostname . "/api/rest/authn", false, $context), true);
    } else {
        $userpass = json_encode(array('type' => 'username', 'id' => $id, 'username' => $uname), true);
        $opts = array(
            'http' =>
            array(
                'method'  => 'POST',
                'header'  => "Content-Type: application/json",
                'content' => $userpass
            )
        );
        $context  = stream_context_create($opts);
        json_decode(file_get_contents("https://" . $hostname . "/api/rest/authn", false, $context), true);



        $userpass = json_encode(array('type' => 'password', 'id' => $id, 'password' => $passwd), true);
        $opts = array(
            'http' =>
            array(
                'method'  => 'POST',
                'header'  => "Content-Type: application/json",
                'content' => $userpass
            )
        );
        $context  = stream_context_create($opts);
        $result = json_decode(file_get_contents("https://" . $hostname . "/api/rest/authn", false, $context), true);
    }

    if (isset($result['error']['message'])) {
        return array(false, $result);
    } else {
        return array(true, $result);
    }
}
