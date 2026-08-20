<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

$id = $_GET['id'];

if (isset($_POST['update'])) {

    $course_id = $_POST['course_id'];
    $term_id = $_POST['term_id'];
    $section_number = $_POST['section_number'];
    $max_capacity = $_POST['max_capacity'];

    // Prepared statement to securely UPDATE section details
    $update_stmt = mysqli_prepare($conn, "UPDATE Sections SET course_id=?, term_id=?, section_number=?, max_capacity=? WHERE section_id=?");
    mysqli_stmt_bind_param($update_stmt, "iisii", $course_id, $term_id, $section_number, $max_capacity, $id);

    if (mysqli_stmt_execute($update_stmt)) {
        mysqli_stmt_close($update_stmt);
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Error Updating Section');</script>";
        mysqli_stmt_close($update_stmt);
    }
}

// Prepared statement to securely FETCH existing section data
$select_stmt = mysqli_prepare($conn, "SELECT * FROM Sections WHERE section_id = ?");
mysqli_stmt_bind_param($select_stmt, "i", $id);
mysqli_stmt_execute($select_stmt);
$result = mysqli_stmt_get_result($select_stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($select_stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Section</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Section</h2>

    <form method="POST">
        <div class="mb-3">
            <label>Course ID</label>
            <input type="number" name="course_id" class="form-control" value="<?php echo htmlspecialchars($row['course_id'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label>Term ID</label>
            <input type="number" name="term_id" class="form-control" value="<?php echo htmlspecialchars($row['term_id'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label>Section Number</label>
            <input type="text" name="section_number" class="form-control" value="<?php echo htmlspecialchars($row['section_number'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label>Maximum Capacity</label>
            <input type="number" name="max_capacity" class="form-control" value="<?php echo htmlspecialchars($row['max_capacity'] ?? ''); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary" name="update">Update Section</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
