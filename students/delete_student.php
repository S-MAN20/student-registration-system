<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepared statement to securely delete student
    $stmt = mysqli_prepare($conn, "DELETE FROM Students WHERE student_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

header("Location: index.php");
exit();
?>
