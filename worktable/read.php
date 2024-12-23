<?php

use objects\Worktable;

header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    include_once '../config/database.php';
    include_once '../objects/Worktable.php';
    $database = new Database();
    $db = $database->getConnection();
    $worktable = new Worktable($db);
    $stmt=$worktable->readAll();
    $num = $stmt->rowCount();
    if($num>0){
        $worktable_arr=array();
        $worktable_arr["records"]=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $worktable_item=array(
                "work_id"=>$work_id,
                "company_name"=>$company_name,
                "work_date"=>$work_date,
                "hours_spend"=>$hours_spend,
            );
            $worktable_arr["records"][] = $worktable_item;
        }
        http_response_code(200);
        echo json_encode($worktable_arr);
    }
    else
    {
        http_response_code(404);
        echo json_encode(array("message" => "Работы не найдены."),
            JSON_UNESCAPED_UNICODE);
    }