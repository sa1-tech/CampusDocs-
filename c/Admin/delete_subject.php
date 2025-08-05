<?php
session_start();
include_once('includes/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['uname'])) {
    $_SESSION['error'] = "Unauthorized access!";
    header("location:index.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Check if this subject has linked units
    $check = mysqli_query($conn, "SELECT COUNT(*) as unit_count FROM units WHERE subject_id = $id");
    $result = mysqli_fetch_assoc($check);

    if ($result['unit_count'] > 0) {
        $_SESSION['error'] = "Cannot delete subject: Linked units exist.";
    } else {
        $delete = mysqli_query($conn, "DELETE FROM subjects WHERE id = $id");
        $_SESSION['success'] = $delete ? "Subject deleted successfully!" : "Failed to delete subject.";
    }
} else {
    $_SESSION['error'] = "Invalid subject ID.";
}

header("Location: subjects.php");
exit;
?>
