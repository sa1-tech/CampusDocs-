<?php
session_start();
include_once('includes/config.php');

if (!isset($_SESSION['uname'])) {
    $_SESSION['error'] = "Unauthorized access!";
    header("location:index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['course_name']);

    if ($name) {
        $insert = mysqli_query($conn, "INSERT INTO courses (name) VALUES ('$name')");

        if ($insert) {
            $_SESSION['success'] = "Course added successfully!";
            header("Location: courses.php");
            exit;
        } else {
            $error = "Insert failed: " . mysqli_error($conn);
        }
    } else {
        $error = "Course name is required.";
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
            <h4>Add New Course</h4>
            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="post">
                <div class="form-group">
                    <label>Course Name</label>
                    <input type="text" name="course_name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Course</button>
            </form>
        </div>
    </section>
</div>
<?php include_once('includes/footer.php'); ?>
</div>
<?php include_once('includes/script.php'); ?>
</body>
</html>
