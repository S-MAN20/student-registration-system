<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

if (isset($_POST['save'])) {

    $term_name = $_POST['term_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Prepared statement to securely insert term
    $stmt = mysqli_prepare($conn, "INSERT INTO Terms (term_name, start_date, end_date) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $term_name, $start_date, $end_date);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Term Added Successfully');</script>";
    } else {
        echo "<script>alert('Error Adding Term');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Term</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Add Term</h2>

    <form method="POST">
        <div class="mb-3">
            <label>Term Name</label>
            <input type="text" name="term_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <button class="btn btn-primary" name="save">Save Term</button>
        <a href="../dashboard/dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
