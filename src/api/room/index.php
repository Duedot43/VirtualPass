<?php
include "../modules.php";


if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW']) and vp_auth("../../../config/config.ini", $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'], "api") and ck_request()){
    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        print_r(explode("/", $_SERVER['REQUEST_URI']));
        $request = unsetValue(explode("/", $_SERVER['REQUEST_URI']), array("api", "room"));
        print_r($request);
    }
}
