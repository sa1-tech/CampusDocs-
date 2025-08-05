<?php
session_start();
include_once('includes/config.php');

// Auth check
if (!isset($_SESSION['uname'])) {
    $_SESSION['error'] = "Unauthorized access!";
    header("location:index.php");
    exit;
}

// Fetch all courses for dropdown
$courses = mysqli_query($conn, "SELECT id, name FROM courses");

// Insert handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $course_id = (int) $_POST['course_id'];

    if (!empty($name) && $course_id > 0) {
        $insert = mysqli_query($conn, "INSERT INTO semesters (name, course_id) VALUES ('$name', '$course_id')");
        if ($insert) {
            $_SESSION['success'] = "Semester added successfully!";
            header("Location: semesters.php");
            exit;
        } else {
            $error = "Insert failed: " . mysqli_error($conn);
        }
    } else {
        $error = "Semester name and course must be selected.";
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
                <h4>Add New Semester</h4>
                <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <form method="post">
                    <div class="form-group">
                        <label>Semester Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Select Course</label>
                        <select name="course_id" class="form-control" required onchange="updateCourseName(this)">
                            <option value="">-- Select Course --</option>
                            <?php while($course = mysqli_fetch_assoc($courses)): ?>
                                <option value="<?= $course['id'] ?>" data-name="<?= htmlspecialchars($course['name']) ?>">
                                    <?= htmlspecialchars($course['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Selected Course Name</label>
                        <input type="text" id="course_name_display" class="form-control" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Semester</button>
                </form>
            </div>
        </section>
    </div>
    <?php include_once('includes/footer.php'); ?>
</div>
<?php include_once('includes/script.php'); ?>

<!-- Add JavaScript for displaying selected course name -->
<script>
function updateCourseName(select) {
    const selectedOption = select.options[select.selectedIndex];
    const courseName = selectedOption.getAttribute('data-name') || '';
    document.getElementById('course_name_display').value = courseName;
}
</script>

</body>
</html>
