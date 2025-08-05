<?php
session_start();
include_once('includes/config.php');
if (!isset($_SESSION['uname'])) {
    $_SESSION['error'] = "Unauthorized access!";
    header("location:index.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$result = mysqli_query($conn, "SELECT * FROM courses WHERE id = $id");
$course = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    // $code = trim($_POST['course_code']);
    
    if ($name) {
        $update = mysqli_query($conn, "UPDATE courses SET name='$name' WHERE id=$id");
        if ($update) {
            $_SESSION['success'] = "Course updated successfully!";
            header("Location: courses.php");
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
            <h4>Edit Course</h4>
            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form method="post">
                <div class="form-group">
                    <label>Course Name</label>
                    <input type="text" name="name" class="form-control" value="<?= $course['name'] ?>" required>
                </div>
                
                <button type="submit" class="btn btn-success">Update Course</button>
            </form>
        </div>
    </section>
</div>
<?php include_once('includes/footer.php'); ?>
</div>
<?php include_once('includes/script.php'); ?>
</body>
</html>
