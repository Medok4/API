<?php

use objects\Checkwork;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../config/database.php';
    include_once '../objects/Checkwork.php';
    $database = new Database();
    $db = $database->getConnection();
    $checkwork = new Checkwork($db);
    $data = json_decode(file_get_contents("php://input"));
//    echo $data->product_name;
////    echo $data->description;
//    echo $data->price;
//    echo $data->category_id;
    if(!empty($data->check_id)&&!empty($data->employee_id)&&!empty($data->work_id)) {
        $checkwork->check_id = $data->check_id;
        $checkwork->employee_id = $data->employee_id;
        $checkwork->work_id = $data->work_id;
        if ($checkwork->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Проверка была создана"),
                JSON_UNESCAPED_UNICODE);
        }
        else
        {
            http_response_code(503);
            echo json_encode(array("message" => "Невозможно создать проверку."),
            JSON_UNESCAPED_UNICODE);
        }
    }
    else
    {
        http_response_code(400);
        echo json_encode(array("message" => "Невозможно создать проверку, данные неполные",JSON_UNESCAPED_UNICODE));
    }