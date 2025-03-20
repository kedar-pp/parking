<?php
session_start();
include("../includes/dbconn.php");

$query = "SELECT v.*, u.name, u.email, u.phone FROM vehicle_logs v JOIN users u ON v.user_id = u.id WHERE v.payment_status = 'Paid' ORDER BY v.exit_time DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transactions</title>
</head>
<body>
    <h2>Completed Payments</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Vehicle No</th>
            <th>Entry Time</th>
            <th>Exit Time</th>
            <th>Amount (₹)</th>
            <th>Payment Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["name"] . " (" . $row["email"] . ")"; ?></td>
                <td><?php echo $row["vehicle_no"]; ?></td>
                <td><?php echo $row["entry_time"]; ?></td>
                <td><?php echo $row["exit_time"]; ?></td>
                <td>₹<?php echo number_format($row["amount"], 2); ?></td>
                <td><?php echo $row["payment_status"]; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
