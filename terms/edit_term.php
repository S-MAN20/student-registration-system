<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

$id = $_GET['id'];

if (isset($_POST['update'])) {

    $term_name = $_POST['term_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Prepared statement to securely UPDATE term details
    $update_stmt = mysqli_prepare($conn, "UPDATE Terms SET term_name=?, start_date=?, end_date=? WHERE term_id=?");
    mysqli_stmt_bind_param($update_stmt, "sssi", $term_name, $start_date, $end_date, $id);

    if (mysqli_stmt_execute($update_stmt)) {
        mysqli_stmt_close($update_stmt);
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Error Updating Term');</script>";
        mysqli_stmt_close($update_stmt);
    }
}

// Prepared statement to securely FETCH existing term data
$select_stmt = mysqli_prepare($conn, "SELECT * FROM Terms WHERE term_id = ?");
mysqli_stmt_bind_param($select_stmt, "i", $id);
mysqli_stmt_execute($select_stmt);
$result = mysqli_stmt_get_result($select_stmt);
$row = mysqli_fetch_assoc($result);
mysqli_stmt_close($select_stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Term</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Term</h2>

    <form method="POST">
        <div class="mb-3">
            <label>Term Name</label>
            <input type="text" name="term_name" class="form-control" value="<?php echo htmlspecialchars($row['term_name'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($row['start_date'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($row['end_date'] ?? ''); ?>" required>
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update Term</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
