<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

$result = $conn->query("SELECT * FROM Sections");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Sections</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Sections List</h2>

<a href="add_section.php" class="btn btn-success mb-3">Add New Section</a>
<a href="../dashboard/dashboard.php" class="btn btn-secondary mb-3">Dashboard</a>

<table class="table table-bordered table-striped">

<tr>
    <th>ID</th>
    <th>Course ID</th>
    <th>Term ID</th>
    <th>Section Number</th>
    <th>Maximum Capacity</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>
    <td><?php echo $row['section_id']; ?></td>
    <td><?php echo $row['course_id']; ?></td>
    <td><?php echo $row['term_id']; ?></td>
    <td><?php echo $row['section_number']; ?></td>
    <td><?php echo $row['max_capacity']; ?></td>

    <td>
        <a href="edit_section.php?id=<?php echo $row['section_id']; ?>" class="btn btn-warning btn-sm">Edit</a>

        <a href="delete_section.php?id=<?php echo $row['section_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
    </td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>