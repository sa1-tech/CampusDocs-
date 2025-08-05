<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Get raw JSON input
$data = json_decode(file_get_contents("php://input"));

if (
    isset($data->full_name) &&
    isset($data->email) &&
    isset($data->password)
) {
    $full_name = $data->full_name;
    $email = $data->email;
    $password = md5($data->password); // NOTE: use password_hash() in production

    $conn = new mysqli("localhost", "root", "", "cd");

    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "DB Connection failed"]);
        exit();
    }

    // Check if email already exists
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Email already registered"]);
        exit();
    }

    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$full_name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Registered successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Registration failed"]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid input. Please send name, email, password"]);
}
?>
