<?php
use objects\Employee;
header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../config/database.php';
    include_once '../objects/Employee.php';
    $database = new Database();
    $db = $database->getConnection();
    $employee = new Employee($db);
    $data = json_decode(file_get_contents("php://input"));
    $employee->employee_id = $data->employee_id;
    $employee->employee_name = $data->employee_name;
    $employee->last_name = $data->last_name;
    $employee->middle_name = $data->middle_name;
    $employee->birth_date = $data->birth_date;
    $employee->work_phone_number = $data->work_phone_number;
    $employee->passport_number = $data->passport_number;
    $employee->category_number = $data->category_number;
    if($employee->update()){
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