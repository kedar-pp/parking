<?php
include("includes/dbconn.php"); // Ensure correct path
session_start();

// Correct SQL query
$query = "SELECT id, name, email, phone, vehicle_no FROM users";
$result = $conn->query($query);

// Check for errors
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Details</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <h2>Registered Users</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Vehicle No</th>
            </tr>
            <?php 
            while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['vehicle_no']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
