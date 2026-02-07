<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] === "OPTIONS"){
    http_response_code(200);
    exit;
}

require "../config/db.php";

$json = file_get_contents("php://input");
$data = json_decode($json);

if(!$data || empty($data->email) || empty($data->password)){
    echo json_encode(["status" => "error", "message" => "Username or password cannot be empty."]);
    exit;
}

$email = $data->email;
$password = $data->password;

$check = $conn->prepare("SELECT id, password from users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if($user = $result->fetch_assoc()){
    if(password_verify($password, $user['password'])){
        echo json_encode(["status" => "success", "user_id" => $user['id'], "message" => "Login Successfully."]);
    }else{
        echo json_encode(["status" => "error", "message" => "Invalid email or password."]);
    }
}else{
    echo json_encode(["status" => "error", "message" => "Invalid email or password."]);
}
?>