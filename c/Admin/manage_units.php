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

// Fetch units with subject details
function getUnits($conn) {
    $qry = "SELECT u.id, u.unit_name, u.subject_id, s.name AS subject_name, u.pdf_url
            FROM units u
            JOIN subjects s ON u.subject_id = s.id";
    return mysqli_query($conn, $qry);
}

$units = getUnits($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Units | CampusDocs</title>
    <?php include_once('includes/style.php'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <h3>Manage Units</h3>
                <a href="add_unit.php" class="btn btn-primary">Add New Unit</a>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Unit Name</th>
                        <th>Subject</th>
                        <th>PDF</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($unit = mysqli_fetch_assoc($units)): ?>
                        <tr>
                            <td><?php echo $unit['id']; ?></td>
                            <td><?php echo $unit['unit_name']; ?></td>
                            <td><?php echo $unit['subject_name']; ?></td>
                            <td>
    <a href="uploads/<?php echo htmlspecialchars($unit['pdf_url']); ?>" target="_blank">
        <?php echo 'uploads/' . htmlspecialchars($unit['pdf_url']); ?>
    </a>
</td>

                            <td>
                                <a href="edit_unit.php?id=<?php echo $unit['id']; ?>">Edit</a> |
                                <a href="delete_unit.php?id=<?php echo $unit['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <?php include_once('includes/footer.php'); ?>
</div>

<?php include_once('includes/script.php'); ?>
</body>
</html>
