<?php
include 'db_config.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = md5($data->password);

$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    echo json_encode(["success" => true, "user_id" => $user['id'], "full_name" => $user['full_name']]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid credentials"]);
}
?>
