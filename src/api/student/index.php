<?php
include "../modules.php";


header("content-type: application/json; charset=utf-8");
if (isset($_SERVER['PHP_AUTH_USER']) and isset($_SERVER['PHP_AUTH_PW']) and vp_auth("../../../config/config.ini", $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'], "api") and ck_request()){
    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        $request = unsetValue(explode("/", $_SERVER['REQUEST_URI']), array("api", "student"));
        if (!isset($request[0])){
            $mass = readJson("../../../mass.json");
            if ($mass != false){
                $output = array("success"=>1);
                foreach ($mass['user'] as $student_id){
                    $output['student'][$student_id] = readJson("../../registered_phid/" . $student_id);
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
                if (ifnumeric($request[0])){
                    $student = readJson("../../registered_phid/" . $request[0]);
                    if ($student != false){
                        $output = array(
                            "success"=>1,
                            "student"=>array(
                                $request[0]=>$student
                            )
                        );
                        echo json_encode($output);
                        exit();
                    } else{
                        echo '{"success":0, "reason":"no_student", "human_reason":"The student id you specified could not be found"}';err();
                        exit();
                    }
                } else{
                    echo '{"success":0, "reason":"not_numeric", "human_reason":"The student you requested is not numeric"}';err();
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
        $request = unsetValue(explode("/", $_SERVER['REQUEST_URI']), array("api", "student"));
        if ($post_arr == false or !isset($post_arr['student'])){
            echo '{"success":0, "reason":"invalid_post", "human_reason":"The post data you send either is not valid or non exiestant"}';err();
            exit();
        }
        $mass = readJson("../../../mass.json");
            if ($mass != false){
                if (!isset($request[0])){
                    if (verifyStudentPut($post_arr['student'])){
                        //put to all users
                        foreach ($mass['user'] as $student_id){
                            file_put_contents("../../registered_phid/" . $student_id, $post_arr['student']);
                        }
                        echo '{"success":1}';
                        exit();
                    } else{
                        echo '{"success":0, "reason":"invalid_student", "human_reason":"The student json you submitted is invalid"}';err();
                        exit();
                    }
                } else{
                    if (verifyStudentPut($post_arr['student'])){
                        //put to one user
                        if (is_numeric((int) $request[0]) and verifyStudentPut($post_arr['student'])){
                            file_put_contents("../../registered_phid/" . $request[0], $post_arr['student']);
                            echo '{"success":1}';
                            exit();
                        } else{
                            echo '{"success":0, "reason":"not_numeric", "human_reason":"The student you requested is not numeric"}';err();
                            exit();
                        }
                    } else{
                        echo '{"success":0, "reason":"invelid_student", "human_reason":"The student json you submitted is invalid"}';err();
                        exit();
                    }
                   
                }

            } else{
                echo '{"success":0, "reason":"no_mass", "human_reason":"The mass.json file could not be located"}';err();
                exit();
            }
    }

    //end of put section

    if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
        $request = unsetValue(explode("/", $_SERVER['REQUEST_URI']), array("api", "student"));
        $mass = readJson("../../../mass.json");
            if ($mass != false){
                if (!isset($request[0])){
                    foreach ($mass['user'] as $student_id){
                        $student = readJson("../../registered_phid/" . $request[0]);
                        unlink("../../registered_phid/" . $request[0]);
                        unset($mass['user'][$request[0]]);
                        $mass['removed'][$request[0]] = $student;
                    }
                    file_put_contents("../../../mass.json", json_encode($mass));
                    echo '{"success":1}';
                    exit();
                } else{
                    if (ifnumeric($request[0])){
                        if (file_exists(("../../registered_phid/" . $request[0]))){
                            $student = readJson("../../registered_phid/" . $request[0]);
                            unlink("../../registered_phid/" . $request[0]);
                            unset($mass['user'][$request[0]]);
                            $mass['removed'][$request[0]] = $student;
                            file_put_contents("../../../mass.json", json_encode($mass));
                            echo '{"success":1}';
                            exit();
                        } else{
                            echo '{"success":0, "reason":"no_user", "human_reason":"The student you requested does not exist"}';err();
                            exit();
                        }
                    } else{
                        echo '{"success":0, "reason":"not_numeric", "human_reason":"The student you requested is not numeric"}';err();
                            exit();
                    }
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
