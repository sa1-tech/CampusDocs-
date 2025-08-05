<?php
session_start();
include_once('includes/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['uname'])) {
    $_SESSION['error'] = "You must login first.";
    header("location:index.php");
    exit;
}

// Fetch Courses and Semesters
$courses = mysqli_query($conn, "SELECT id, name FROM courses");
$semesters = mysqli_query($conn, "SELECT id, name FROM semesters");

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $course_id = (int) $_POST['course_id'];
    $semester_id = (int) $_POST['semester_id'];

    if ($name && $course_id && $semester_id) {
        $insert = mysqli_query($conn, "INSERT INTO subjects(name, course_id, semester_id) VALUES('$name', '$course_id', '$semester_id')");
        if ($insert) {
            $_SESSION['success'] = "Subject added successfully!";
            header("Location: subjects.php");
            exit;
        } else {
            $error = "Error: " . mysqli_error($conn);
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
                <h4>Add New Subject</h4>
                <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <form method="post">
                    <div class="form-group">
                        <label>Subject Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Select Course</label>
                        <select name="course_id" class="form-control" required>
                            <option value="">-- Select Course --</option>
                            <?php while($c = mysqli_fetch_assoc($courses)): ?>
                                <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Semester</label>
                        <select name="semester_id" class="form-control" required>
                            <option value="">-- Select Semester --</option>
                            <?php while($s = mysqli_fetch_assoc($semesters)): ?>
                                <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Subject</button>
                </form>
            </div>
        </section>
    </div>

    <?php include_once('includes/footer.php'); ?>
</div>
<?php include_once('includes/script.php'); ?>
</body>
</html>
