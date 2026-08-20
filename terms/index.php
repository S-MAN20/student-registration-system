<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/database.php");

$result = $conn->query("SELECT * FROM Terms");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Terms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

<h2>Terms List</h2>

<a href="add_term.php" class="btn btn-success mb-3">Add New Term</a>
<a href="../dashboard/dashboard.php" class="btn btn-secondary mb-3">Dashboard</a>

<table class="table table-bordered table-striped">

<tr>
    <th>ID</th>
    <th>Term Name</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['term_id']; ?></td>
<td><?php echo $row['term_name']; ?></td>
<td><?php echo $row['start_date']; ?></td>
<td><?php echo $row['end_date']; ?></td>

<td>

<a href="edit_term.php?id=<?php echo $row['term_id']; ?>" class="btn btn-warning btn-sm">Edit</a>

<a href="delete_term.php?id=<?php echo $row['term_id']; ?>" class="btn btn-danger btn-sm">Delete</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>