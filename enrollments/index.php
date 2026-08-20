<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

$sql = "SELECT e.enrollment_id,
               s.first_name,
               s.last_name,
               c.course_title,
               sec.section_number,
               t.term_name,
               e.status,
               e.grade
        FROM Enrollments e
        JOIN Students s ON e.student_id = s.student_id
        JOIN Sections sec ON e.section_id = sec.section_id
        JOIN Courses c ON sec.course_id = c.course_id
        JOIN Terms t ON sec.term_id = t.term_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Enrollments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Enrollment List</h2>

<table class="table table-bordered">
<thead>
<tr>
<th>ID</th>
<th>Student</th>
<th>Course</th>
<th>Section</th>
<th>Term</th>
<th>Status</th>
<th>Grade</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['enrollment_id']; ?></td>

<td><?php echo $row['first_name']." ".$row['last_name']; ?></td>

<td><?php echo $row['course_title']; ?></td>

<td><?php echo $row['section_number']; ?></td>

<td><?php echo $row['term_name']; ?></td>

<td><?php echo $row['status']; ?></td>

<td><?php echo $row['grade']; ?></td>

<td>
<a href="edit_enrollment.php?id=<?php echo $row['enrollment_id']; ?>" class="btn btn-warning btn-sm">Edit</a>

<a href="delete_enrollment.php?id=<?php echo $row['enrollment_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
</td>

</tr>

<?php } ?>

</tbody>
</table>

<a href="add_enrollment.php" class="btn btn-primary">Add New Enrollment</a>
<a href="../dashboard/dashboard.php" class="btn btn-secondary">Back</a>

</div>

</body>
</html>