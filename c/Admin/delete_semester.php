<?php
session_start();
include_once('includes/config.php');

if (!isset($_SESSION['uname'])) {
    $_SESSION['error'] = "You must be logged in.";
    header("Location: index.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    $_SESSION['error'] = "Invalid semester ID.";
    header("Location: semesters.php");
    exit;
}

// Step 1: Get all subject IDs linked to this semester
$subjectStmt = $conn->prepare("SELECT id FROM subjects WHERE semester_id = ?");
$subjectStmt->bind_param("i", $id);
$subjectStmt->execute();
$subjectResult = $subjectStmt->get_result();

$subjectIds = [];
while ($row = $subjectResult->fetch_assoc()) {
    $subjectIds[] = $row['id'];
}

// Step 2: Delete units linked to those subjects
if (!empty($subjectIds)) {
    $in = implode(',', array_fill(0, count($subjectIds), '?'));
    $types = str_repeat('i', count($subjectIds));

    $deleteUnitsStmt = $conn->prepare("DELETE FROM units WHERE subject_id IN ($in)");
    $deleteUnitsStmt->bind_param($types, ...$subjectIds);
    $deleteUnitsStmt->execute();

    // Step 3: Delete subjects
    $deleteSubjectsStmt = $conn->prepare("DELETE FROM subjects WHERE id IN ($in)");
    $deleteSubjectsStmt->bind_param($types, ...$subjectIds);
    $deleteSubjectsStmt->execute();
}

// Step 4: Delete semester
$deleteSemesterStmt = $conn->prepare("DELETE FROM semesters WHERE id = ?");
$deleteSemesterStmt->bind_param("i", $id);
$deleteSemesterStmt->execute();

if ($deleteSemesterStmt->affected_rows > 0) {
    $_SESSION['success'] = "Semester and all related subjects/units deleted successfully!";
} else {
    $_SESSION['error'] = "Failed to delete semester.";
}

header("Location: semesters.php");
exit;
