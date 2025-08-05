<?php
include_once('includes/config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Enable exceptions for better debugging
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        // First delete the course
        $query = "DELETE FROM courses WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            // ✅ Redirect after successful deletion
            header("Location: courses.php");
            exit(); // Always call exit after header redirect
        } else {
            echo "Error deleting course: " . mysqli_error($conn);
        }
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage();
    }
}
?>
