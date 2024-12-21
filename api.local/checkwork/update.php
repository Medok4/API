<?php
use objects\Checkwork;
header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../config/database.php';
    include_once '../objects/Checkwork.php';
    $database = new Database();
    $db = $database->getConnection();
    $checkwork = new Checkwork($db);
    $data = json_decode(file_get_contents("php://input"));
    $checkwork->check_id = $data->check_id;
    $checkwork->employee_id = $data->employee_id;
    $checkwork->work_id = $data->work_id;
    if($checkwork->update()){
        http_response_code(200);
        echo json_encode(array("message" => "Проверка обновлена."),
            JSON_UNESCAPED_UNICODE);
    }
    else
    {
        http_response_code(583);
        echo json_encode(array("message" => "Невозможно обновить проверку."),
            JSON_UNESCAPED_UNICODE);
    }