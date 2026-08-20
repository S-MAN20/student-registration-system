<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

$id = $_GET['id'];

if (isset($_POST['update'])) {

    $status = $_POST['status'];
    $grade = $_POST['grade'];

    // Secure Prepared Statement for UPDATE query
    $update_stmt = mysqli_prepare($conn, "UPDATE Enrollments SET status=?, grade=? WHERE enrollment_id=?");
    mysqli_stmt_bind_param($update_stmt, "ssi", $status, $grade, $id);

    if (mysqli_stmt_execute($update_stmt)) {
        mysqli_stmt_close($update_stmt);
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Error updating record.');</script>";
        mysqli_stmt_close($update_stmt);
    }
}

// Secure Prepared Statement for SELECT query
$select_stmt = mysqli_prepare($conn, "SELECT * FROM Enrollments WHERE enrollment_id = ?");
mysqli_stmt_bind_param($select_stmt, "i", $id);
mysqli_stmt_execute($select_stmt);
$result = mysqli_stmt_get_result($select_stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($select_stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Enrollment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Enrollment</h2>

    <form method="POST">
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="Registered" <?php if(($row['status'] ?? '') == "Registered") echo "selected"; ?>>Registered</option>
                <option value="Completed" <?php if(($row['status'] ?? '') == "Completed") echo "selected"; ?>>Completed</option>
                <option value="Dropped" <?php if(($row['status'] ?? '') == "Dropped") echo "selected"; ?>>Dropped</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Grade</label>
            <input type="text" name="grade" class="form-control" value="<?php echo htmlspecialchars($row['grade'] ?? ''); ?>">
        </div>

        <button class="btn btn-success" name="update">Update Enrollment</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
