<?php

use objects\User;

header("Access-Control-Allow-Origin: http://authentication-jwt/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Подключение к БД
// Файлы, необходимые для подключения к базе данных
include_once '../config/database.php';
include_once '../objects/User.php';

// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "User"
$user = new User($db);
$data = json_decode(file_get_contents("php://input"));

// Устанавливаем значения
$user->firstname = $data->firstname;
$user->lastname = $data->lastname;
$user->email = $data->email;
$user->password = $data->password;
if (
    !empty($user->firstname) &&
    !empty($user->email) &&
    // $email_exists == 0 &&
    !empty($user->password) &&
    $user->create()
) {
    // Устанавливаем код ответа
    http_response_code(200);
    // Покажем сообщение о том, что пользователь был создан
    echo json_encode(array("message" => "Пользователь был создан"));
}
// Сообщение, если не удаётся создать пользователя
else {

    // Устанавливаем код ответа
    http_response_code(400);
    // Покажем сообщение о том, что создать пользователя не удалось
    echo json_encode(array("message" => "Невозможно создать пользователя"));
}