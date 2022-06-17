<?php
include "../modules.php";


header("content-type: application/json; charset=utf-8");
if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW']) and vp_auth("../../../config/config.ini", $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'], "api") and ck_request()){
    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        $request = unsetValue(explode("/", $_SERVER['REQUEST_URI']), array("api", "room"));
        if (!isset($request[0])){
            $mass = readJson("../../../mass.json");
            if ($mass != false){
                $output = array();
                foreach ($mass['room'] as $room_id){
                    $output[$room_id] = read_file("../../registerd_qrids/" . $room_id);
                }
                echo json_encode($output);
                exit();
            } else{
                echo '{"success":0, "reason":"no_mass", "human_reason":"The mass.json file could not be located"}';
                exit();
            }
        } else{
            $mass = readJson("../../../mass.json");
            if ($mass != false){
                $room = read_file("../../registerd_qrids/" . $request[0]);
                if ($room != false){
                    echo json_encode($output);
                    exit();
                } else{
                    echo '{"success":0, "reason":"no_room", "human_reason":"The room id you specified could not be found"}';
                    exit();
                }
            } else{
                echo '{"success":0, "reason":"no_mass", "human_reason":"The mass.json file could not be located"}';
                exit();
            }
        }
    }
} else{
    echo '{"success":0, "reason":"invalid_auth", "human_reason":"The authentication you supplied was incrrect"}';
    exit();
}
