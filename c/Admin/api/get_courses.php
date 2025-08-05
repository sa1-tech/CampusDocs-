<?php
header("Content-Type: application/json");
include 'db_config.php';

$result = mysqli_query($conn, "SELECT * FROM courses");
$courses = [];

while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row;
}

echo json_encode($courses);
?>
