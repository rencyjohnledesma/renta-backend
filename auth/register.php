<?php
// 1. Allow React to access this script
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Handle preflight 'OPTIONS' requests (browsers send this before the actual POST)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require "../config/db.php";

// 2. Get the raw body data
$json = file_get_contents("php://input");
$data = json_decode($json);

// 3. Simple validation to prevent errors if $data is empty
if (!$data || empty($data->email) || empty($data->password)) {
    echo json_encode(["status" => "error", "message" => "All fields are required!"]);
    exit;
}

$firstname = $data->firstName;
$lastname  = $data->lastName;
$email     = $data->email;
$password  = password_hash($data->password, PASSWORD_DEFAULT);

// 4. Check if email exists
$check = $conn->prepare("SELECT id FROM users WHERE email=?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if($check->num_rows > 0){
    echo json_encode(["status" => "error", "message" => "Email already exists"]);
    exit;
}

// 5. Insert user
$stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password) VALUES (?,?,?,?)");
$stmt->bind_param("ssss", $firstname, $lastname, $email, $password);

if($stmt->execute()){
    echo json_encode(["status" => "success", "message" => "Account registered successfully"]);
} else {
    // It's helpful to see the SQL error during development
    echo json_encode(["status" => "error", "message" => "Registration Failed: " . $stmt->error]);
}
?>