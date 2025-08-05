<?php
header("Content-Type: application/json");
include 'db_config.php';

$course_id = $_GET['course_id'];
$semester_id = $_GET['semester_id'];

$result = mysqli_query($conn, "SELECT * FROM subjects WHERE course_id='$course_id' AND semester_id='$semester_id'");
$subjects = [];

while ($row = mysqli_fetch_assoc($result)) {
    $subjects[] = $row;
}

echo json_encode($subjects);
?>
