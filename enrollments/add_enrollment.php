<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

if (isset($_POST['save'])) {

    $student_id = $_POST['student_id'];
    $section_id = $_POST['section_id'];
    $status = $_POST['status'];
    $grade = $_POST['grade'];

    // Prepared statement to securely insert enrollment
    $stmt = mysqli_prepare($conn, "INSERT INTO Enrollments (student_id, section_id, status, grade) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iiss", $student_id, $section_id, $status, $grade);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Enrollment Added Successfully');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_stmt_error($stmt) . "');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Enrollment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Add Enrollment</h2>

    <form method="POST">
        <div class="mb-3">
            <label>Student</label>
            <select name="student_id" class="form-control" required>
                <option value="">Select Student</option>
                <?php
                $result = $conn->query("SELECT * FROM Students");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['student_id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Section</label>
            <select name="section_id" class="form-control" required>
                <option value="">Select Section</option>
                <?php
                $result = $conn->query("SELECT * FROM Sections");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['section_id'] . "'>Section " . $row['section_number'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Registered">Registered</option>
                <option value="Dropped">Dropped</option>
                <option value="Completed">Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Grade</label>
            <input type="text" name="grade" class="form-control">
        </div>

        <button class="btn btn-primary" name="save">Save Enrollment</button>
        <a href="../dashboard/dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
