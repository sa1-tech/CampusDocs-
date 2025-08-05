<?php 
session_start();
include_once('includes/config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Whitelisted count retrieval function
function getCount($conn, $table) {
    $allowedTables = ['courses', 'subjects', 'semesters', 'users'];
    if (!in_array($table, $allowedTables)) return 0;

    $qry = "SELECT COUNT(*) as count FROM `$table`";
    $stmt = $conn->prepare($qry);
    $stmt->execute();
    $result = $stmt->get_result();
    return ($result) ? (int)$result->fetch_assoc()['count'] : 0;
}

// Fetch counts for courses, subjects, semesters, and users
$courseCount = getCount($conn, 'courses');
$subjectCount = getCount($conn, 'subjects');
$semesterCount = getCount($conn, 'semesters');
$userCount = getCount($conn, 'users');

// Fetch recently added PDFs from units table
$query = "SELECT * FROM units WHERE pdf_url IS NOT NULL ORDER BY created_at DESC LIMIT 8";
$recentPdfs = mysqli_query($conn, $query);

if (!isset($_SESSION['uname'])) {
    $_SESSION['error'] = "You are not authorized to access this page without login";
    header("location:index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CampusDocs | Dashboard</title>
    <?php include_once('includes/style.php'); ?>

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .content-wrapper {
            padding: 20px;
        }

        .dashboard-welcome {
            font-size: 1.5rem;
            font-weight: 600;
            color: #4A90E2;
            margin-bottom: 20px;
        }

        .small-box {
            transition: all 0.3s ease;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .small-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .small-box .inner {
            padding: 10px;
        }

        .small-box h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
        }

        .small-box p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .small-box.bg-info {
            background-color: #17a2b8;
        }

        .small-box.bg-warning {
            background-color: #ffc107;
        }

        .small-box.bg-success {
            background-color: #28a745;
        }

        .small-box.bg-primary {
            background-color: #007bff;
        }

        .icon i {
            font-size: 40px;
            color: rgba(255, 255, 255, 0.8);
        }

        .breadcrumb {
            font-size: 1rem;
        }

        .alert {
            border-radius: 5px;
            padding: 10px;
            font-size: 1rem;
        }

        .alert-dismissible .close {
            font-size: 1.25rem;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        .alert-danger {
            background-color: #dc3545;
            color: white;
        }

        @media (max-width: 768px) {
            .small-box {
                padding: 15px;
            }

            .small-box h3 {
                font-size: 1.5rem;
            }
        }
    </style>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="CampusDocsLogo" height="60" width="60">
    </div> -->

    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/sidebar.php'); ?>

    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                        <div class="dashboard-welcome">
                            👋 Welcome, <strong><?php echo $_SESSION['uname']; ?></strong>!
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Courses Box -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo $courseCount; ?></h3>
                                <p>Total Courses</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-book-reader"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Subjects Box -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo $subjectCount; ?></h3>
                                <p>Total Subjects</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Semesters Box -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo $semesterCount; ?></h3>
                                <p>Total Semesters</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Users Box -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3><?php echo $userCount; ?></h3>
                                <p>Total Users</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart for data visualization -->
                <div class="row">
                    <div class="col-12">
                    <canvas id="dataChart" width="550" height="550"></canvas>

                    </div>
                </div>

                <!-- Recently Added PDFs -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recently Added PDFs</h3>
                                <input type="text" id="pdfSearch" placeholder="Search PDFs..." class="form-control mb-3" onkeyup="filterPdfs()">
                            </div>
                            <div class="card-body">
                                <ul class="list-group" id="pdfList">
                                    <?php while ($pdf = mysqli_fetch_assoc($recentPdfs)): ?>
                                        <li class="list-group-item">
                                            <a href="uploads/<?php echo $pdf['pdf_url']; ?>" target="_blank"><?php echo $pdf['pdf_url']; ?></a>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alerts -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <?php include_once('includes/footer.php'); ?>

</div>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
// Chart.js data visualization
var ctx = document.getElementById('dataChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Courses', 'Subjects', 'Semesters', 'Users'],
        datasets: [{
            data: [<?php echo $courseCount; ?>, <?php echo $subjectCount; ?>, <?php echo $semesterCount; ?>, <?php echo $userCount; ?>],
            backgroundColor: ['#17a2b8', '#ffc107', '#28a745', '#007bff'],
            borderColor: ['#fff', '#fff', '#fff', '#fff'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,  // Set to false to allow width/height adjustments
        plugins: {
            legend: {
                position: 'top',
            },
        },
    }
});


// PDF filter function
document.getElementById('pdfSearch').addEventListener('input', function () {
    const filter = this.value.toLowerCase();
    const items = document.querySelectorAll('#pdfList li');
    let matchFound = false;

    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        if (text.includes(filter)) {
            item.style.display = '';
            matchFound = true;
        } else {
            item.style.display = 'none';
        }
    });

    const noResult = document.querySelector('.no-results');
    if (!matchFound && !noResult) {
        const li = document.createElement('li');
        li.className = 'list-group-item no-results';
        li.textContent = 'No PDFs found.';
        document.getElementById('pdfList').appendChild(li);
    } else if (matchFound && noResult) {
        noResult.remove();
    }
});

</script>
</body>
</html>
