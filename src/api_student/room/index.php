<?php
include "../../api/modules.php";



if (isset($_SERVER['PHP_AUTH_USER']) and apiAuth($_SERVER['PHP_AUTH_USER'], "../../../mass.json")) {
    $key = $_SERVER['PHP_AUTH_USER'];
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $mass = readJson("../../../mass.json");
        $request = unsetValue(explode("/", $_SERVER['REQUEST_URI']), array("api_student", "room"));
        if (isset($request[0])) {
            foreach ($mass['room'] as $room_id) {
                $realRoom = read_file("../../registerd_qrids/" . $room_id);
                if ((int) $realRoom == (int) $request[0]) {
                    $output = array(
                        "success" => 1,
                        $request[0] => $room_id
                    );
                    echo json_encode($output);
                    exit();
                }
            }
            echo '{"success":0, "reason":"no_room", "human_reason":"The room you requested does not exist"}';
            exit();
        } else {
            echo '{"success":0, "reason":"no_request", "human_reason":"You did not request a room"}';
            exit();
        }
    }
} else {
    echo '{"success":0, "reason":"invalid_auth", "human_reason":"Your api key is not present"}';
    exit();
}
