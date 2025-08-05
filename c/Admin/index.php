<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in (v2)💊</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <style>
        /* Gradient background */
        body {
            background: linear-gradient(135deg, #FF3E30, #FFB829);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Source Sans Pro', sans-serif;
        }

        /* Card shadow effect */
        .login-box {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            border-radius: 15px; /* Rounded corners for the card */
            overflow: hidden; /* Prevents child elements from overflowing */
        }

        /* Input field shadow effect */
        .form-control {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid #ddd;
            transition: border-color 0.3s ease, box-shadow 0.7s ease, transform 0.7s ease, background-color 0.3s ease;
        }

        /* Button shadow effect */
        .btn {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.9);
        }

        /* Hover effects for inputs */
        .form-control:focus {
            border-color: #FFB829; /* Yellow border on focus */
            box-shadow: 0 0 15px rgba(255, 184, 41, 0.7); /* Yellow shadow */
            transform: scale(1.02); /* Scale up slightly */
            background-color: #fff; /* Background on focus */
        }

        /* Button hover effects */
        .btn-primary {
            background-color: #FF3E30; /* Red background */
            border: none; /* No border */
            transition: background-color 0.5s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #FFB829; /* Change to yellow on hover */
            transform: scale(1.05); /* Scale up on hover */
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.7); /* Larger shadow on hover */
        }

        .btn-primary:active {
            transform: scale(0.95); /* Scale down on click */
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="index.php" class="h3"><b>CampusDocs<br>Admin</b></a>
        </div>
        <div class="card-body">
            <?php
            if(isset($_SESSION['error'])) {
            ?>
                <p class="login-box-msg text-danger"><?php echo $_SESSION['error']; ?></p>
            <?php
            unset($_SESSION['error']);
            }
            ?>

            <form action="login_check.php" method="post">
                <div class="input-group mb-3" style="margin-bottom: 15px;">
                    <input type="email" class="form-control" placeholder="Email" name="email"
                        style="border-radius: 10px; padding: 12px; font-size: 16px;"
                        onfocus="this.style.borderColor='#FFB829';">
                    <div class="input-group-append">
                        <div class="input-group-text" style="background-color: #FF3E30; border-radius: 0 10px 10px 0;">
                            <span class="fas fa-user" style="color: white;"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3" style="margin-bottom: 15px;">
                    <input type="password" class="form-control" placeholder="Password" name="password"
                        style="border-radius: 10px; padding: 12px; font-size: 16px;"
                        onfocus="this.style.borderColor='#FFB829';">
                    <div class="input-group-append">
                        <div class="input-group-text" style="background-color: #FF3E30; border-radius: 0 10px 10px 0;">
                            <span class="fas fa-lock" style="color: white;"></span>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <!-- Additional elements can be added here -->
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">
                        Sign In
                    </button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
