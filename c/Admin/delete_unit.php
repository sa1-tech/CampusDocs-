<?php
session_start();
include_once('includes/config.php');

if (!isset($_SESSION['uname'])) {
    $_SESSION['error'] = "You are not authorized to access this page without login";
    header("location:index.php");
    exit;
}

$id = $_GET['id'] ?? 0;

$query = "DELETE FROM units WHERE id = $id";
if (mysqli_query($conn, $query)) {
    $_SESSION['success'] = "Unit deleted successfully!";
} else {
    $_SESSION['error'] = "Error: " . mysqli_error($conn);
}

header("Location: manage_units.php");
exit;
