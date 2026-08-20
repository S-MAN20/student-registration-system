<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

$id = $_GET['id'];

if (isset($_POST['update'])) {

    $course_code = $_POST['course_code'];
    $course_title = $_POST['course_title'];
    $credits = $_POST['credits'];

    // Prepared statement to securely UPDATE course details
    $update_stmt = mysqli_prepare($conn, "UPDATE Courses SET course_code=?, course_title=?, credits=? WHERE course_id=?");
    mysqli_stmt_bind_param($update_stmt, "ssii", $course_code, $course_title, $credits, $id);

    if (mysqli_stmt_execute($update_stmt)) {
        mysqli_stmt_close($update_stmt);
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Error Updating Course');</script>";
        mysqli_stmt_close($update_stmt);
    }
}

// Prepared statement to securely FETCH existing course data
$select_stmt = mysqli_prepare($conn, "SELECT * FROM Courses WHERE course_id = ?");
mysqli_stmt_bind_param($select_stmt, "i", $id);
mysqli_stmt_execute($select_stmt);
$result = mysqli_stmt_get_result($select_stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($select_stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Course</h2>

    <form method="POST">
        <div class="mb-3">
            <label>Course Code</label>
            <input type="text" name="course_code" class="form-control" value="<?php echo htmlspecialchars($row['course_code']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Course Title</label>
            <input type="text" name="course_title" class="form-control" value="<?php echo htmlspecialchars($row['course_title']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Credits</label>
            <input type="number" name="credits" class="form-control" value="<?php echo htmlspecialchars($row['credits']); ?>" required>
        </div>

        <button class="btn btn-primary" name="update">Update Course</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
