<?php
session_start();
include_once('includes/config.php');

// Auth check
if (!isset($_SESSION['uname'])) {
    header("location:index.php");
    exit;
}

$id = $_GET['id'] ?? 0;

// Get current semester data
$result = mysqli_query($conn, "SELECT * FROM semesters WHERE id=$id");
$semester = mysqli_fetch_assoc($result);

// Get all courses for dropdown
$courses = mysqli_query($conn, "SELECT id, name FROM courses");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $course_id = (int) $_POST['course_id'];

    if (!empty($name) && $course_id > 0) {
        $update = mysqli_query($conn, "UPDATE semesters SET name='$name', course_id='$course_id' WHERE id=$id");

        if ($update) {
            $_SESSION['success'] = "Semester updated successfully!";
            header("Location: semesters.php");
            exit;
        } else {
            $error = "Update failed: " . mysqli_error($conn);
        }
    } else {
        $error = "Semester name and course must not be empty.";
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
                <h4>Edit Semester</h4>
                <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <form method="post">
                    <div class="form-group">
                        <label>Semester Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($semester['name']) ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Select Course</label>
                        <select name="course_id" class="form-control" required>
                            <option value="">-- Select Course --</option>
                            <?php while ($course = mysqli_fetch_assoc($courses)) : ?>
                                <option value="<?= $course['id'] ?>" <?= ($semester['course_id'] == $course['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($course['name']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </section>
    </div>
    <?php include_once('includes/footer.php'); ?>
</div>
<?php include_once('includes/script.php'); ?>
</body>
</html>
