<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: delete");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/Employee.php';
$database = new Database();
$db = $database->getConnection();
$employee = new \objects\Employee($db);
$data = json_decode(file_get_contents("php://input"));
$employee->employee_id = $data->employee_id;
if($employee->delete()) {
    http_response_code(200);
    echo json_encode(array("message" => "Сотрудник удален."),
        JSON_UNESCAPED_UNICODE);
}
else
{
    http_response_code(503);
    echo json_encode(array("message" => "Невозможно удалить сотрудника."),
        JSON_UNESCAPED_UNICODE);
}
