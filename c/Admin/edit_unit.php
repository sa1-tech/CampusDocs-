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

$id = $_GET['id'] ?? 0;
$unit_query = "SELECT * FROM units WHERE id = $id";
$unit_result = mysqli_query($conn, $unit_query);

if (mysqli_num_rows($unit_result) == 0) {
    $_SESSION['error'] = "Unit not found!";
    header("Location: manage_units.php");
    exit;
}

$unit = mysqli_fetch_assoc($unit_result);
$subjects = mysqli_query($conn, "SELECT id, name FROM subjects");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unit_name = mysqli_real_escape_string($conn, $_POST['unit_name']);
    $subject_id = (int) $_POST['subject_id'];
    $pdf_url = $_FILES['pdf']['name'] ? $_FILES['pdf']['name'] : $unit['pdf_url'];

    if ($_FILES['pdf']['name']) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($pdf_url);
        move_uploaded_file($_FILES['pdf']['tmp_name'], $target_file);
    }

    $update_query = "UPDATE units SET unit_name = '$unit_name', subject_id = $subject_id, pdf_url = '$pdf_url' WHERE id = $id";
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['success'] = "Unit updated successfully!";
        header("location: manage_units.php");
        exit;
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Unit | CampusDocs</title>
    <?php include_once('includes/style.php'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <h3>Edit Unit</h3>
                <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Unit Name</label>
                        <input type="text" name="unit_name" class="form-control" value="<?= $unit['unit_name'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Subject</label>
                        <select name="subject_id" class="form-control" required>
                            <option value="">-- Select Subject --</option>
                            <?php while($subject = mysqli_fetch_assoc($subjects)): ?>
                                <option value="<?= $subject['id'] ?>" <?= ($subject['id'] == $unit['subject_id']) ? 'selected' : '' ?>><?= $subject['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Upload PDF (optional)</label>
                        <input type="file" name="pdf" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Unit</button>
                </form>
            </div>
        </section>
    </div>

    <?php include_once('includes/footer.php'); ?>
</div>

<?php include_once('includes/script.php'); ?>
</body>
</html>
