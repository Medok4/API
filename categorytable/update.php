<?php
use objects\Categorytable;
header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../config/database.php';
    include_once '../objects/Categorytable.php';
    $database = new Database();
    $db = $database->getConnection();
    $categorytable = new Categorytable($db);
    $data = json_decode(file_get_contents("php://input"));
    $categorytable->category_number = $data->category_number;
    $categorytable->money_for_hour = $data->money_for_hour;
    if($categorytable->update()){
        http_response_code(200);
        echo json_encode(array("message" => "Категория обновлена."),
            JSON_UNESCAPED_UNICODE);
    }
    else
    {
        http_response_code(583);
        echo json_encode(array("message" => "Невозможно обновить категория."),
            JSON_UNESCAPED_UNICODE);
    }