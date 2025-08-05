<?php
header("Content-Type: application/json");
header("Content-Type: application/pdf");
include 'db_config.php';

$unit_id = $_GET['unit_id'];
$result = mysqli_query($conn, "SELECT * FROM units WHERE id='$unit_id'");
$row = mysqli_fetch_assoc($result);

echo json_encode(["pdf_url" => $row['pdf_url']]);
?>
