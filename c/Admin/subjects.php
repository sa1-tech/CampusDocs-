<?php
session_start();
include_once('includes/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['uname'])) {
    $_SESSION['error'] = "You are not authorized to access this page without login";
    header("location:index.php");
    exit;
}

// Fetch subjects with course and semester names
function getSubjects($conn) {
    $qry = "SELECT s.id, s.name AS subject_name, c.name AS course_name, sem.name AS semester_name
            FROM subjects s
            JOIN semesters sem ON s.semester_id = sem.id
            JOIN courses c ON sem.course_id = c.id
            ORDER BY s.id ASC";
    return mysqli_query($conn, $qry);
}

$subjects = getSubjects($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subjects | CampusDocs</title>
    <?php include_once('includes/style.php'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>

    <div class="content-wrapper">
        <section class="content pt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

                        <h3>Manage Subjects</h3>
                        <a href="add_subject.php" class="btn btn-primary mb-2">Add New Subject</a>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Subject Name</th>
                                <th>Course</th>
                                <th>Semester</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($subject = mysqli_fetch_assoc($subjects)): ?>
                                <tr>
                                    <td><?php echo $subject['id']; ?></td>
                                    <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                                    <td><?php echo htmlspecialchars($subject['course_name']); ?></td>
                                    <td><?php echo htmlspecialchars($subject['semester_name']); ?></td>
                                    <td>
                                        <a href="edit_subject.php?id=<?php echo $subject['id']; ?>">Edit</a> |
                                        <a href="delete_subject.php?id=<?php echo $subject['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include_once('includes/footer.php'); ?>
</div>

<?php include_once('includes/script.php'); ?>
</body>
</html>
