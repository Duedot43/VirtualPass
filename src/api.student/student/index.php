<?php
include "../../api/modules.php";



if (isset($_SERVER['PHP_AUTH_USER']) and apiAuth($_SERVER['PHP_AUTH_USER'], "../../../mass.json")) {
    $key = $_SERVER['PHP_AUTH_USER'];
    $user = readJson("../../../mass.json")['apiKeys'][$key];
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $userJson = array(
            "success" => 1,
            $user => readJson("../../registered_phid/" . $user)
        );
        echo json_encode($userJson);
        exit();
    } elseif ($_SERVER['REQUEST_METHOD'] == "PATCH") {
        $json = readJson("php://input");
        if (isset($json['rooms']) and is_array($json['room'])) {
            $userJson = readJson("../../registered_phid/" . $user);
            $userJson['rooms'] = $json['rooms'];
            file_put_contents("../../registered_phid/" . $user, json_encode($userJson));
            $userJson = array(
                "success" => 1,
                $user => readJson("../../registered_phid/" . $user)
            );
            echo json_encode($userJson);
            exit();
        } else {
            echo '{"success":0, "reason":"no_rooms", "human_reason":"The rooms value in the POST data does not exist or is not an array"}';
            exit();
        }
    }
} else {
    echo '{"success":0, "reason":"invalid_auth", "human_reason":"Your api key is not present"}';
    exit();
}
