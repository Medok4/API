<?php

use objects\Categorytable;

header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    include_once '../config/database.php';
    include_once '../objects/Categorytable.php';

    $database = new Database();
    $db = $database->getConnection();
    $categorytable = new Categorytable($db);
    $keywords = isset($_GET['s']) ? $_GET['s'] : "";
    $stmt = $categorytable->search($keywords);
    $num = $stmt->rowCount();
    if($num>0){
        $categorytable_arr = array();
        $categorytable_arr["records"] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $categorytable_item = array(
                "category_number" => $category_number,
                "money_for_hour" => $money_for_hour,
            );
            array_push($categorytable_arr["records"], $categorytable_item);
        }
        http_response_code(200);
        echo json_encode($categorytable_arr);
    }
    else{
        http_response_code(404);
        echo json_encode(array("message" => "Категории не найдены."),JSON_UNESCAPED_UNICODE);
    }
