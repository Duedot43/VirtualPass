<?php
include "../modules.php";


header("content-type: application/json; charset=utf-8");
if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW']) and vp_auth("../../../config/config.ini", $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'], "api") and ck_request()){
    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        $request = unsetValue(explode("/", $_SERVER['REQUEST_URI']), array("api", "room"));
        if (!isset($request[0])){
            $mass = readJson("../../../mass.json");
            if ($mass != false){
                $output = array("success"=>1);
                foreach ($mass['room'] as $room_id){
                    $output['room'][read_file("../../registerd_qrids/" . $room_id)] = $room_id;
                }
                echo json_encode($output);
                exit();
            } else{
                echo '{"success":0, "reason":"no_mass", "human_reason":"The mass.json file could not be located"}';err();
                exit();
            }
        } else{
            $mass = readJson("../../../mass.json");
            if ($mass != false){
                $room = read_file("../../registerd_qrids/" . $request[0]);
                if ($room != false){
                    $output = array(
                        "success"=>1,
                        "room"=>array(
                            $request[0]=>$room
                        )
                    );
                    echo json_encode($output);
                    exit();
                } else{
                    echo '{"success":0, "reason":"no_room", "human_reason":"The room id you specified could not be found"}';err();
                    exit();
                }
            } else{
                echo '{"success":0, "reason":"no_mass", "human_reason":"The mass.json file could not be located"}';err();
                exit();
            }
        }
    }

    //End of the GET request section

    if ($_SERVER['REQUEST_METHOD'] == "PUT"){
        $post_arr = json_decode(file_get_contents("php://input"), true);
        $request = unsetValue(explode("/", $_SERVER['REQUEST_URI']), array("api", "room"));
        if ($post_arr == false or !isset($post_arr['room'])){
            echo '{"success":0, "reason":"invalid_post", "human_reason":"The post data you send either is not valid or non exiestant"}';err();
            exit();
        }
        $mass = readJson("../../../mass.json");
            if ($mass != false){
                if (!isset($request[0])){
                    //put to all users
                    foreach ($mass['room'] as $room_id){
                        file_put_contents("../../registerd_qrids/" . $room_id, $post_arr['room']);
                    }
                    echo '{"success":1}';
                    exit();
                } else{
                    //put to one user
                    file_put_contents("../../registerd_qrids/" . $request[0], $post_arr['room']);
                    echo '{"success":1}';
                    exit();
                   
                }

            } else{
                echo '{"success":0, "reason":"no_mass", "human_reason":"The mass.json file could not be located"}';err();
                exit();
            }
    }

    //end of put section

    if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
        $request = unsetValue(explode("/", $_SERVER['REQUEST_URI']), array("api", "room"));
        $mass = readJson("../../../mass.json");
            if ($mass != false){
                if (!isset($request[0])){
                    foreach ($mass['room'] as $room_id){
                        unlink("../../registerd_qrids/" . $room_id);
                        echo '{"success":1}';
                        exit();
                    }
                } else{
                    unlink("../../registerd_qrids/" . $$request[0]);
                    echo '{"success":1}';
                    exit();
                }

            } else{
                echo '{"success":0, "reason":"no_mass", "human_reason":"The mass.json file could not be located"}';err();
                exit();
            }
    }
} else{
    echo '{"success":0, "reason":"invalid_auth", "human_reason":"The authentication you supplied was incrrect"}';authFail();
    exit();
}
