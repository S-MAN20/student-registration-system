<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

$students   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Students"));
$courses    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Courses"));
$terms      = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Terms"));
$enrollments = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Enrollments"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Registration System</title>
    <!-- Custom Modern Dashboard Styling -->
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>

    <!-- Top Navigation Header -->
    <header class="navbar">
        <a href="dashboard.php" class="navbar-brand">Student Registration System</a>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span class="nav-link">Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
            <a href="../login/logout.php" class="btn btn-primary" style="padding: 0.4rem 0.85rem; font-size: 0.85rem;">Logout</a>
        </div>
    </header>

    <!-- Main Content Layout -->
    <main class="container">
        <h2>Dashboard Overview</h2>

        <!-- Key Metrics Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem;">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Total Students</div>
                    <div class="card-value"><?php echo $students; ?></div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">Total Courses</div>
                    <div class="card-value"><?php echo $courses; ?></div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">Total Terms</div>
                    <div class="card-value"><?php echo $terms; ?></div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">Total Enrollments</div>
                    <div class="card-value"><?php echo $enrollments; ?></div>
                </div>
            </div>
        </div>

        <!-- System Navigation Panel -->
        <section style="margin-top: 2.5rem; background: #ffffff; padding: 1.5rem; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h3 style="margin-top: 0; font-size: 1.1rem; color: #64748b; margin-bottom: 1rem;">Quick Navigation</h3>
            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                <a href="../students/" class="btn btn-primary">Students</a>
                <a href="../courses/" class="btn btn-primary">Courses</a>
                <a href="../terms/" class="btn btn-primary">Terms</a>
                <a href="../sections/" class="btn btn-primary">Sections</a>
                <a href="../enrollments/" class="btn btn-primary">Enrollments</a>
            </div>
        </section>

        <footer class="footer">
            &copy; <?php echo date("Y"); ?> Student Registration System. All rights reserved.
        </footer>
    </main>

</body>
</html>
