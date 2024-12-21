<?php

use objects\Employee;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once '../config/database.php';
    include_once '../objects/Employee.php';
    $database = new Database();
    $db = $database->getConnection();
    $employee = new Employee($db);
    $data = json_decode(file_get_contents("php://input"));
//    echo $data->product_name;
////    echo $data->description;
//    echo $data->price;
//    echo $data->category_id;
    if(!empty($data->employee_id)&&!empty($data->employee_name)&&!empty($data->last_name)&&!empty($data->middle_name)&&!empty($data->birth_date)&&!empty($data->work_phone_number)&&!empty($data->passport_number)&&!empty($data->category_number)) {
        $employee->employee_id = $data->employee_id;
        $employee->employee_name = $data->employee_name;
        $employee->last_name = $data->last_name;
        $employee->middle_name = $data->middle_name;
        $employee->birth_date = $data->birth_date;
        $employee->work_phone_number = $data->work_phone_number;
        $employee->passport_number = $data->passport_number;
        $employee->category_number = $data->category_number;
        if ($employee->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Сотрудник был создан"),
                JSON_UNESCAPED_UNICODE);
        }
        else
        {
            http_response_code(503);
            echo json_encode(array("message" => "Невозможно создать сотрудника."),
            JSON_UNESCAPED_UNICODE);
        }
    }
    else
    {
        http_response_code(400);
        echo json_encode(array("message" => "Невозможно создать сотрудника, данные неполные",JSON_UNESCAPED_UNICODE));
    }