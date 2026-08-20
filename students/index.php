<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

$result = $conn->query("SELECT * FROM Students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Students List</h2>

<a href="add_student.php" class="btn btn-success mb-3">Add New Student</a>
<a href="../dashboard/dashboard.php" class="btn btn-secondary mb-3">Dashboard</a>

<table class="table table-bordered table-striped">

<tr>
<th>ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Phone</th>
<th>Date of Birth</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['student_id']; ?></td>

<td><?php echo $row['first_name']; ?></td>

<td><?php echo $row['last_name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['phone']; ?></td>

<td><?php echo $row['date_of_birth']; ?></td>

<td>
<a href="edit_student.php?id=<?php echo $row['student_id']; ?>" class="btn btn-warning btn-sm">Edit</a>

<a href="delete_student.php?id=<?php echo $row['student_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>