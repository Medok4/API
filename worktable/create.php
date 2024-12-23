<?php

use objects\Worktable;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../config/database.php';
    include_once '../objects/Worktable.php';
    $database = new Database();
    $db = $database->getConnection();
    $worktable = new Worktable($db);
    $data = json_decode(file_get_contents("php://input"));
//    echo $data->product_name;
////    echo $data->description;
//    echo $data->price;
//    echo $data->category_id;
    if(!empty($data->work_id)&&!empty($data->company_name)&&!empty($data->work_date)&&!empty($data->hours_spend)) {
        $worktable->work_id = $data->work_id;
        $worktable->company_name = $data->company_name;
        $worktable->work_date = $data->work_date;
        $worktable->hours_spend = $data->hours_spend;
        if ($worktable->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Работа была создана"),
                JSON_UNESCAPED_UNICODE);
        }
        else
        {
            http_response_code(503);
            echo json_encode(array("message" => "Невозможно создать работу."),
            JSON_UNESCAPED_UNICODE);
        }
    }
    else
    {
        http_response_code(400);
        echo json_encode(array("message" => "Невозможно создать работу, данные неполные",JSON_UNESCAPED_UNICODE));
    }