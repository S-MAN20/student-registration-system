<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

$id = $_GET['id'];

if (isset($_POST['update'])) {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date_of_birth = $_POST['date_of_birth'];

    // Prepared statement to securely UPDATE student details
    $update_stmt = mysqli_prepare($conn, "UPDATE Students SET first_name=?, last_name=?, email=?, phone=?, date_of_birth=? WHERE student_id=?");
    mysqli_stmt_bind_param($update_stmt, "sssssi", $first_name, $last_name, $email, $phone, $date_of_birth, $id);

    if (mysqli_stmt_execute($update_stmt)) {
        mysqli_stmt_close($update_stmt);
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Error Updating Student Record');</script>";
        mysqli_stmt_close($update_stmt);
    }
}

// Prepared statement to securely FETCH existing student data
$select_stmt = mysqli_prepare($conn, "SELECT * FROM Students WHERE student_id = ?");
mysqli_stmt_bind_param($select_stmt, "i", $id);
mysqli_stmt_execute($select_stmt);
$result = mysqli_stmt_get_result($select_stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($select_stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Student</h2>

    <form method="POST">
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($row['first_name'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($row['last_name'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($row['phone'] ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" value="<?php echo htmlspecialchars($row['date_of_birth'] ?? ''); ?>">
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update Student</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
