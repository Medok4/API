<?php

use objects\Categorytable;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../config/database.php';
    include_once '../objects/Categorytable.php';
    $database = new Database();
    $db = $database->getConnection();
    $categorytable = new Categorytable($db);
    $data = json_decode(file_get_contents("php://input"));
//    echo $data->product_name;
////    echo $data->description;
//    echo $data->price;
//    echo $data->category_id;
    if(!empty($data->category_number)&&!empty($data->money_for_hour)) {
        $categorytable->category_number = $data->category_number;
        $categorytable->money_for_hour = $data->money_for_hour;
        if ($categorytable->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Категория была создана"),
                JSON_UNESCAPED_UNICODE);
        }
        else
        {
            http_response_code(503);
            echo json_encode(array("message" => "Невозможно создать категорию."),
            JSON_UNESCAPED_UNICODE);
        }
    }
    else
    {
        http_response_code(400);
        echo json_encode(array("message" => "Невозможно создать категорию, данные неполные",JSON_UNESCAPED_UNICODE));
    }