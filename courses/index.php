<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

$result = $conn->query("SELECT * FROM Courses");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Courses List</h2>

<a href="add_course.php" class="btn btn-success mb-3">Add New Course</a>
<a href="../dashboard/dashboard.php" class="btn btn-secondary mb-3">Dashboard</a>

<table class="table table-bordered table-striped">

<tr>
<th>ID</th>
<th>Course Code</th>
<th>Course Title</th>
<th>Credits</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['course_id']; ?></td>
<td><?php echo $row['course_code']; ?></td>
<td><?php echo $row['course_title']; ?></td>
<td><?php echo $row['credits']; ?></td>

<td>

<a href="edit_course.php?id=<?php echo $row['course_id']; ?>" class="btn btn-warning btn-sm">Edit</a>

<a href="delete_course.php?id=<?php echo $row['course_id']; ?>" class="btn btn-danger btn-sm">Delete</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>