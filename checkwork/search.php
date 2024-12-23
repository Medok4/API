<?php

use objects\Checkwork;

header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    include_once '../config/database.php';
    include_once '../objects/Checkwork.php';

    $database = new Database();
    $db = $database->getConnection();
    $checkwork = new Checkwork($db);
    $keywords = isset($_GET['s']) ? $_GET['s'] : "";
    $stmt = $checkwork->search($keywords);
    $num = $stmt->rowCount();
    if($num>0){
        $checkwork_arr = array();
        $checkwork_arr["records"] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $checkwork_item = array(
                "check_id" => $check_id,
                "employee_id" => $employee_id,
                "work_id" => $work_id,
            );
            array_push($checkwork_arr["records"], $checkwork_item);
        }
        http_response_code(200);
        echo json_encode($checkwork_arr);
    }
    else{
        http_response_code(404);
        echo json_encode(array("message" => "Категории не найдены."),JSON_UNESCAPED_UNICODE);
    }
