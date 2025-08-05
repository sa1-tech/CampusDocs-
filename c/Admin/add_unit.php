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

// Fetch subjects
$subjects = mysqli_query($conn, "SELECT id, name FROM subjects");

// On form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unit_name = mysqli_real_escape_string($conn, $_POST['unit_name']);
    $subject_id = (int) $_POST['subject_id'];

    // Validate file
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pdf']['tmp_name'];
        $originalName = basename($_FILES['pdf']['name']);
        $safeName = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "_", $originalName);

        $uploadDir = 'uploads/';
        $uploadPath = $uploadDir . $safeName;

        // Move file
        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            // Insert into database
            $query = "INSERT INTO units (unit_name, subject_id, pdf_url)
                      VALUES ('$unit_name', $subject_id, '$safeName')";

            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Unit added successfully!";
                header("location: manage_units.php");
                exit;
            } else {
                $error = "DB Insert Error: " . mysqli_error($conn);
            }
        } else {
            $error = "Failed to move uploaded PDF file.";
        }
    } else {
        $error = "Please upload a valid PDF file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Unit | CampusDocs</title>
    <?php include_once('includes/style.php'); ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <h3>Add New Unit</h3>

                <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <?php if (isset($_SESSION['success'])) {
                    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
                    unset($_SESSION['success']);
                } ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Unit Name</label>
                        <input type="text" name="unit_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Subject</label>
                        <select name="subject_id" class="form-control" required>
                            <option value="">-- Select Subject --</option>
                            <?php while($subject = mysqli_fetch_assoc($subjects)): ?>
                                <option value="<?= $subject['id'] ?>"><?= htmlspecialchars($subject['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Upload PDF</label>
                        <input type="file" name="pdf" class="form-control" accept=".pdf" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Unit</button>
                </form>
            </div>
        </section>
    </div>

    <?php include_once('includes/footer.php'); ?>
</div>
<?php include_once('includes/script.php'); ?>
</body>
</html>
