<?php

use objects\Employee;

header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    include_once '../config/database.php';
    include_once '../objects/Employee.php';
    $database = new Database();
    $db = $database->getConnection();
    $employee = new Employee($db);
    $stmt=$employee->readAll();
    $num = $stmt->rowCount();
    if($num>0){
        $employee_arr=array();
        $employee_arr["records"]=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $employee_item=array(
                "employee_id"=>$employee_id,
                "employee_name"=>$employee_name,
                "last_name"=>$last_name,
                "middle_name"=>$middle_name,
                "birth_date"=>$birth_date,
                "work_phone_number"=>$work_phone_number,
                "passport_number"=>$passport_number,
                "category_number"=>$category_number,
            );
            $employee_arr["records"][] = $employee_item;
        }
        http_response_code(200);
        echo json_encode($employee_arr);
    }
    else
    {
        http_response_code(404);
        echo json_encode(array("message" => "Проверка не найдена."),
            JSON_UNESCAPED_UNICODE);
    }