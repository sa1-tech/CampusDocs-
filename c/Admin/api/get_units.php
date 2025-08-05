<?php
header("Content-Type: application/json");
header("Content-Type: application/pdf");
include 'db_config.php';

$subject_id = $_GET['subject_id'];
$result = mysqli_query($conn, "SELECT * FROM units WHERE subject_id='$subject_id'");
$units = [];

while ($row = mysqli_fetch_assoc($result)) {
    $units[] = $row;
}

echo json_encode($units);
?>
