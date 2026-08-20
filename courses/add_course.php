<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

if (isset($_POST['save'])) {

    $course_code = $_POST['course_code'];
    $course_title = $_POST['course_title'];
    $credits = $_POST['credits'];

    // Secure Prepared Statement to insert course
    $stmt = mysqli_prepare($conn, "INSERT INTO Courses (course_code, course_title, credits) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssi", $course_code, $course_title, $credits);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Course Added Successfully');</script>";
    } else {
        echo "<script>alert('Error Adding Course');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Course</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Add Course</h2>

    <form method="POST">
        <div class="mb-3">
            <label>Course Code</label>
            <input type="text" name="course_code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Course Title</label>
            <input type="text" name="course_title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Credits</label>
            <input type="number" name="credits" class="form-control" required>
        </div>

        <button class="btn btn-primary" name="save">Save Course</button>
        <a href="../dashboard/dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
