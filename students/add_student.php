<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

if (isset($_POST['save'])) {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date_of_birth = $_POST['date_of_birth'];

    // Secure Prepared Statement to insert student
    $stmt = mysqli_prepare($conn, "INSERT INTO Students (first_name, last_name, email, phone, date_of_birth) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $phone, $date_of_birth);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Student Added Successfully');</script>";
    } else {
        echo "<script>alert('Error Adding Student');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Add Student</h2>

    <form method="POST">
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" required>
        </div>

        <button class="btn btn-primary" name="save">Save Student</button>
        <a href="../dashboard/dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
