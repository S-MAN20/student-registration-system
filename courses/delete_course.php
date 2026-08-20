<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepared statement to securely delete course
    $stmt = mysqli_prepare($conn, "DELETE FROM Courses WHERE course_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php");
        exit();
    } else {
        mysqli_stmt_close($stmt);
        echo "Error deleting course.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
