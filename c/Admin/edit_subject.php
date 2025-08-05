<?php
session_start();
include_once('includes/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['uname'])) {
    header("Location: index.php");
    exit;
}

// Safely retrieve the 'id' parameter from the URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Fetch subject details for editing
$query = "SELECT * FROM subjects WHERE id = $id";
$subject_result = mysqli_query($conn, $query);
if (mysqli_num_rows($subject_result) > 0) {
    $subject = mysqli_fetch_assoc($subject_result);
} else {
    // Handle the case if the subject is not found
    $_SESSION['error'] = "Subject not found!";
    header("Location: subjects.php");
    exit;
}

// Fetch all courses and semesters for selection in the form
$courses = mysqli_query($conn, "SELECT id, name FROM courses");
$semesters = mysqli_query($conn, "SELECT id, name FROM semesters");

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the input data
    $subject_name = trim($_POST['subject_name']);
    $course_id = (int) $_POST['course_id'];
    $semester_id = (int) $_POST['semester_id'];

    if ($subject_name && $course_id && $semester_id) {
        // Prepare the query for updating the subject
        $subject_name = mysqli_real_escape_string($conn, $subject_name); // sanitize the input

        $update_query = "UPDATE subjects 
                         SET name = '$subject_name', course_id = $course_id, semester_id = $semester_id 
                         WHERE id = $id";
        
        $update = mysqli_query($conn, $update_query);
        
        if ($update) {
            $_SESSION['success'] = "Subject updated successfully!";
            header("Location: subjects.php");
            exit;
        } else {
            $error = "Update failed: " . mysqli_error($conn);
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<?php include_once('includes/style.php'); ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>

    <div class="content-wrapper">
        <section class="content pt-3">
            <div class="container-fluid">
                <h4>Edit Subject</h4>
                <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <form method="post">
                    <div class="form-group">
                        <label>Subject Name</label>
                        <input type="text" name="subject_name" value="<?= htmlspecialchars($subject['name']) ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Course</label>
                        <select name="course_id" class="form-control" required>
                            <option value="">-- Select Course --</option>
                            <?php while($c = mysqli_fetch_assoc($courses)): ?>
                                <option value="<?= $c['id'] ?>" <?= $c['id'] == $subject['course_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester_id" class="form-control" required>
                            <option value="">-- Select Semester --</option>
                            <?php while($s = mysqli_fetch_assoc($semesters)): ?>
                                <option value="<?= $s['id'] ?>" <?= $s['id'] == $subject['semester_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($s['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Update Subject</button>
                </form>
            </div>
        </section>
    </div>
    <?php include_once('includes/footer.php'); ?>
</div>
<?php include_once('includes/script.php'); ?>
</body>
</html>
