<?php
use objects\Worktable;
header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../config/database.php';
    include_once '../objects/Worktable.php';
    $database = new Database();
    $db = $database->getConnection();
    $worktable = new Worktable($db);
    $data = json_decode(file_get_contents("php://input"));
    $worktable->work_id = $data->work_id;
    $worktable->company_name = $data->company_name;
    $worktable->work_date = $data->work_date;
    $worktable->hours_spend = $data->hours_spend;
    if($worktable->update()){
        http_response_code(200);
        echo json_encode(array("message" => "Работа обновлена."),
            JSON_UNESCAPED_UNICODE);
    }
    else
    {
        http_response_code(583);
        echo json_encode(array("message" => "Невозможно обновить работу."),
            JSON_UNESCAPED_UNICODE);
    }