<?php
header("Content-Type: application/json");
include 'db_config.php';

$course_id = $_GET['course_id'];
$result = mysqli_query($conn, "SELECT * FROM semesters WHERE course_id='$course_id'");
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
    "id" => $row['id'],
    "course_id" => $row['course_id'],
    "name" => "Semester " . $row['name'], // Add prefix
];

}

echo json_encode($data);
?>
