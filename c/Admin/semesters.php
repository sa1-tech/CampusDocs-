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

// Fetch semesters with course name
function getSemesters($conn) {
    $qry = "SELECT semesters.id, semesters.name AS semester_name, semesters.course_id, courses.name AS course_name 
            FROM semesters 
            JOIN courses ON semesters.course_id = courses.id 
            ORDER BY courses.name ASC, semesters.name ASC";
    return mysqli_query($conn, $qry);
}

$semesters = getSemesters($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Semesters | CampusDocs</title>
    <?php include_once('includes/style.php'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h3 class="mt-3">Manage Semesters</h3>
                        <a href="add_semester.php" class="btn btn-primary mb-3">Add New Semester</a>
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Semesters</th>
                                    <th>Course Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($semester = mysqli_fetch_assoc($semesters)): ?>
                                    <tr>
                                        <td><?php echo $semester['id']; ?></td>
                                        <td><?php echo $semester['semester_name']; ?></td>
                                        <td><?php echo $semester['course_name']; ?></td>
                                        <td>
                                            <a href="edit_semester.php?id=<?php echo $semester['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="delete_semester.php?id=<?php echo $semester['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this semester?');">Delete</a>
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
