<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

if (isset($_POST['save'])) {

    $course_id = $_POST['course_id'];
    $term_id = $_POST['term_id'];
    $section_number = $_POST['section_number'];
    $max_capacity = $_POST['max_capacity'];

    // Prepared statement to securely insert section
    $stmt = mysqli_prepare($conn, "INSERT INTO Sections (course_id, term_id, section_number, max_capacity) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iisi", $course_id, $term_id, $section_number, $max_capacity);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Section Added Successfully');</script>";
    } else {
        echo "<script>alert('Error Adding Section');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Section</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Add Section</h2>

    <form method="POST">
        <div class="mb-3">
            <label>Course ID</label>
            <input type="number" name="course_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Term ID</label>
            <input type="number" name="term_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Section Number</label>
            <input type="text" name="section_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Maximum Capacity</label>
            <input type="number" name="max_capacity" class="form-control" required>
        </div>

        <button class="btn btn-primary" name="save">Save Section</button>
        <a href="../dashboard/dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
